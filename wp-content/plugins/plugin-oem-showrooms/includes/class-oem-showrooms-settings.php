<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Oem_Showrooms_Settings {

    private static $_instance = null;

    public $parent = null;

    public function __construct( $parent ) {
        $this->parent = $parent;

        add_action( 'admin_menu', array($this, 'showrooms_menu' ));
        add_filter( 'plugin_action_links', array($this, 'showrooms_add_settings'), 10, 5 );

        add_action( 'showrooms_import_event', array($this, 'showrooms_import') );
    }

    /**
     * @param mixed $parent
     * @return object
     */
    public static function instance ( $parent ) {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self( $parent );
        }
        return self::$_instance;
    }

    public function showrooms_menu()
    {
        $hook = add_options_page(
                __('New Boat Showrooms Settings', 'plugin-oem-showrooms'),
                __('Boat Showrooms', 'plugin-oem-showrooms'),
                'manage_options',
                'oem-showrooms',
                array($this, 'showrooms_options' ) );

        add_action( 'admin_init', array($this, 'register_showrooms_settings' ));
        add_action( 'load-'.$hook, array($this, 'showrooms_post_save_options' ));
    }

    public function showrooms_post_save_options()
    {
        if(!empty($_REQUEST['settings-updated']) && $_REQUEST['page'] == 'oem-showrooms') {
            $mmp_api_key = get_option('mmp_api_key');
            $imt_party_id = get_option('imt_party_id');
            $selected_schedule = get_option(OEM_SHOWROOMS_PREFIX . 'import_frequency');
            $brands = json_decode(get_option(OEM_SHOWROOMS_PREFIX . 'brands'), 1);

            // scheduling import
            $schedules = wp_get_schedules();
            $next_scheduled = time() + intval($schedules[$selected_schedule]['interval']);
            wp_schedule_event($next_scheduled, $selected_schedule, 'showrooms_import_event');

            // rewrite rules
            flush_rewrite_rules();
        }
    }

    public function register_showrooms_settings() {

        $settings = array(
                OEM_SHOWROOMS_PREFIX . 'import_frequency',
                OEM_SHOWROOMS_PREFIX . 'detail_url',
                OEM_SHOWROOMS_PREFIX . 'landing_page_id'
        );

        $brands = json_decode(get_option(OEM_SHOWROOMS_PREFIX . 'brands'), 1);
        if(!empty($brands)) {
            foreach($brands as $brand_key => $brand) {
                $settings[] = OEM_SHOWROOMS_PREFIX . 'brand_page_id_' . $brand_key;
                $settings[] = OEM_SHOWROOMS_PREFIX . 'exclude_' . $brand['id'];
            }
        }

        foreach($settings as $option) {
            register_setting( 'showrooms-settings-group', $option );
        }
    }

    public function showrooms_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        $settings_page = !empty($_REQUEST['request']) ? $_REQUEST['request'] : 'settings';

        switch($settings_page) {
            case 'run-import' :

                // getting brands
                $brand_importer = $this->showrooms_import();
                $brand_import_stats = $brand_importer->get_stats();
                $brand_party_ids = $brand_importer->get_supported_brands_party_ids();

                // testing mmp api
                $testMmpSuccess = $this->showrooms_test_oem_results($brand_party_ids);

                flush_rewrite_rules();

                include(dirname(__FILE__) . '/../run-import.php');
                break;
            default:
                $mmp_api_key = get_option('mmp_api_key');
                $imt_party_id = get_option('imt_party_id');
                $provisioning_url = get_option('provisioning_ws_url');
                $brands = json_decode(get_option('oem_showrooms_brands'), 1);

                $showrooms_page_id = get_option('oem_showrooms_landing_page_id');

                $url_showroom_detail = get_option('oem_showrooms_detail_url');

                // get exclusion lists
                $excludes = array();
                if (!empty($brands)) {
                    foreach ($brands as $key => $brand) {
                        $excludes[$brand['id']] = get_option(OEM_SHOWROOMS_PREFIX . 'exclude_' . $brand['id']);
                    }
                }
                // what is parent page slug
                $landing_page_slug = self::get_landing_page_slug();

                include(dirname(__FILE__) . '/../settings.php');
        }


    }

    /**
     * Add Settings
     *
     * @param array $actions
     * @param string $plugin_file
     * @return array
     */
    public function showrooms_add_settings( $actions, $plugin_file )
    {
        if (strstr($plugin_file, 'oem-showrooms')) {

            $settings = array(
                    'settings' => '<a href="options-general.php?page=oem-showrooms">' . __('Settings', 'plugin-oem-showrooms') . '</a>',
                    'import'   => '<a href="options-general.php?page=oem-showrooms&request=run-import">' . __('Run Import', 'plugin-oem-showrooms') . '</a>'
            );
            $actions = array_merge($settings, $actions);
        }

        return $actions;
    }

    /**
     * Supported brands import
     */
    public function showrooms_import()
    {
        $party_id = get_option('imt_party_id');
        $provisioning_ws_url = get_option('provisioning_ws_url');

        $importer = new Import_Supported_Brands($provisioning_ws_url, $party_id);
        $brands = $importer->get_supported_brand_parties();

        if(!isset($brands)) {
            return $importer;
        }

        update_option(OEM_SHOWROOMS_PREFIX . 'brands', json_encode($brands));
        update_option(OEM_SHOWROOMS_PREFIX . 'brands_updated', time());

        // generate pages if necessary
        $this->showrooms_generate_pages($brands);

        // make each page aware of the brand it's representing
        $this->showrooms_brand_page_update($brands);

        return $importer;
    }

    /**
     * Test connectivity to search API
     *
     * @param array $brand_party_ids
     * @return boolean
     */
    private function showrooms_test_oem_results($brand_party_ids = array())
    {
        $mmp_api_key = get_option('mmp_api_key');
        $api = new Mmp_API($mmp_api_key);

        if(!empty($brand_party_ids)) {
            foreach($brand_party_ids as $party_id) {
                $api->set_party_id($party_id);
                $api->set_current_page(1);
                $api->set_fields('DocumentID');
                $api->set_results_per_page(1);
                $api->set_sort_by(null);
                $api->set_current_models(null);
                $result = $api->get_results();
                $num_results = $api->get_num_results_last_query();

                if($num_results > 0) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Generate showroom and brand pages. Also assign them
     * the correct templates and brand_id as meta
     *
     * @param array $brands
     */
    private function showrooms_generate_pages($brands)
    {
        // insert showrooms detail page
        // this page should not be editable
        $details_page_id = get_option(OEM_SHOWROOMS_PREFIX . 'detail_page_id');
        if(empty($details_page_id)) {
            $post = array(
                    'post_name'     => 'showroom-details',
                    'post_title'    => __('Manufacturer Showrooms Details Page', 'plugin-oem-showrooms'),
                    'post_content'  => '-- ' . __('This is a placeholder page used by plugin-oem-showrooms. Do not remove' . ' --', 'plugin-oem-showrooms'),
                    'post_status'   => 'publish',
                    'post_type'     => 'page'
            );
            $details_page_id = wp_insert_post( $post, false );
            update_post_meta($details_page_id, '_wp_page_template',  'page-showroom-model-details.php');
            update_option(OEM_SHOWROOMS_PREFIX . 'detail_page_id', $details_page_id);
        }

        // insert showrooms landing page
        $showrooms_page_id = get_option(OEM_SHOWROOMS_PREFIX . 'landing_page_id');
        if(empty($showrooms_page_id)) {
            $post = array(
                    'post_name'     => 'new-boat-showrooms',
                    'post_title'    => __('Manufacturer Showrooms', 'plugin-oem-showrooms'),
                    'post_content'  => '',
                    'post_status'   => 'publish',
                    'post_type'     => 'page'
            );

            $showrooms_page_id = wp_insert_post( $post, false );
            update_post_meta($showrooms_page_id, '_wp_page_template',  'page-showrooms.php');
            update_option(OEM_SHOWROOMS_PREFIX . 'landing_page_id', $showrooms_page_id);
        }

        // find which brands already have pages?
        $existing_brand_option_keys = $this->get_brand_page_id_option_keys();

        // insert brand pages
        $brand_page_ids = array();
        foreach($brands as $brandKey => $brand)
        {
            // does this brand have a page?
            $brand_page_option_key = OEM_SHOWROOMS_PREFIX . 'brand_page_id_' . $brandKey;
            $brand_page_ids[$brandKey] = get_option($brand_page_option_key);

            // we want to know what brands have been removed from provisioning
            $existing_brand_option_keys = array_diff($existing_brand_option_keys, array($brand_page_option_key));

            // only create the page if it doesnt exist
            if(empty($brand_page_ids[$brandKey])) {
                $post = array(
                    'post_parent'   => intval($showrooms_page_id),
                    'post_name'     => Showrooms_URL_Helper::slugify($brand['name']),
                    'post_title'    => __(sprintf('%s New Boat Models', $brand['name']) , 'plugin-oem-showrooms'),
                    'post_content'  => '',
                    'post_status'   => 'publish',
                    'post_type'     => 'page'
                );

                $post_id = wp_insert_post( $post, false );

                update_post_meta($post_id, '_wp_page_template',  'page-showroom-models.php');
                update_post_meta($post_id, OEM_SHOWROOMS_PREFIX . 'brand_id',  $brand['id']);

                update_option(OEM_SHOWROOMS_PREFIX . 'brand_page_id_' . $brandKey, $post_id);
            }

        }

        /*
         ** now remove pages removed from provisioning
        foreach($existing_brand_option_keys as $brand_page_option)
        {
            $option_value = get_option($brand_page_option);
            delete_option($brand_page_option);

            if(intval($option_value) > 0) {
                wp_delete_post($option_value, true);
            }
        }
        */


    }

    /**
     * Gets brand_page_id options keys
     * @return array $option_name
     */
    private function get_brand_page_id_option_keys()
    {
        $query = 'SELECT option_name FROM wp_options WHERE option_name LIKE "' . OEM_SHOWROOMS_PREFIX  . 'brand_page_id%"';
        $existing_brand_pages = $GLOBALS['wpdb']->get_results( $query );
        $existing_brand_option_keys = array();
        if(!empty($existing_brand_pages)) {
            foreach($existing_brand_pages as $brand_page) {
                $existing_brand_option_keys[] = $brand_page->option_name;
            }
        }

        return $existing_brand_option_keys;
    }

    /**
     * Save brand id as a meta for brand pages
     *
     * @param array $brands
     */
    private function showrooms_brand_page_update($brands) {

        delete_post_meta_by_key(OEM_SHOWROOMS_PREFIX . 'brand_id');

        if(!empty($brands)) {
            foreach($brands as $brandKey => $brand) {
                $page_id = get_option(OEM_SHOWROOMS_PREFIX . 'brand_page_id_' . $brandKey);

                if(!empty($page_id)) {
                    update_post_meta($page_id, OEM_SHOWROOMS_PREFIX . 'brand_id',  $brand['id']);
                }
            }
        }
    }

    /**
     * Get showrooms landing page slug
     *
     * @return string
     */
    public static function get_landing_page_slug()
    {
        $landing_page_id = get_option(OEM_SHOWROOMS_PREFIX . 'landing_page_id');
        if(!empty($landing_page_id)) {
            $landing_page = get_post($landing_page_id, ARRAY_A);
        }

        $landing_page_slug = !empty($landing_page['post_name']) ?
        $landing_page['post_name'] :
        'new-boat-showrooms';

        return $landing_page_slug;
    }

}
