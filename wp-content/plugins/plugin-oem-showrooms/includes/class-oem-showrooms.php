<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Oem_Showrooms {
    
    private static $_instance = null;
       
    public $settings = null;
    public $file;
    public $dir;
    
    public function __construct(  $file = '', $version = '1.0.0' ) {
        
        $this->file = $file;
        $this->dir = dirname( $this->file );
        
        add_action( 'init', array( $this, 'showrooms_init' ), 1 );
        
        register_activation_hook( $this->file, array( $this, 'showrooms_activation' ) );
        register_deactivation_hook( $this->file, 'showrooms_deactivation' );
        
        add_filter('rewrite_rules_array', array($this, 'oem_showrooms_add_rewrite_rules') );
        add_filter('query_vars', array($this, 'oem_showrooms_add_query_vars') );
        
        // import crons
        add_filter( 'cron_schedules', array($this, 'cron_add_weekly') );
        add_filter( 'cron_schedules', array($this, 'cron_add_biweekly') );
        add_filter( 'cron_schedules', array($this, 'cron_add_monthly') );
        
        // redirect rules
        add_action( 'template_redirect', array($this, 'oem_showrooms_template_redirect') );
        
        // additional page options
        add_action( 'add_meta_boxes', array($this, 'oem_showrooms_add_meta_box') );
        add_action( 'save_post', array($this, 'oem_showrooms_save_post'));
        
        // admin remove logo
        add_action( 'wp_ajax_showrooms_remove_logo', array($this, 'showrooms_remove_logo' ) );
        
        // seo override and api calls
        add_filter( 'get_header', array($this,'showrooms_get_header') );
     
        // initialize Widget
        add_action('widgets_init', function(){
            register_widget('Showrooms_More_From');
        });        
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
    
    /**
     * Override SEO and perform API calls
     * for showroom detail page
     */
    public function showrooms_get_header()
    {
        global $wp_query, $post;
        
        if($post->post_name == 'showroom-details') {
            
            // api calls
            $post->boat = Showrooms_Helper::get_boat_details($wp_query->query['DocumentID']);
            $post->more_from_make = Showrooms_Helper::more_from_make($post->boat['Owner']['PartyId'], 
                $post->boat['MakeString'], $wp_query->query['DocumentID']);
            
            // override wordpress-seo meta description
            add_filter( 'wpseo_metadesc', array($this,'showooms_add_meta_description'), 10, 1 );
            add_filter( 'wpseo_canonical', array($this, 'showooms_remove_meta_canonical'), 10, 1);
            add_action( 'wp_head', array($this, 'showooms_add_meta_ogimage'), 1, 1 );
            
            $post->post_title = $post->boat['ModelYear'] . ' ' . 
                $post->boat['MakeString'] . ' ' .
                $post->boat['Model'];
            
        }
    }
    
    /**
     * Add first image as og:image meta tag
     */
    public function showooms_add_meta_ogimage()
    {
        global $post;
        
        if(isset($post->boat['Images'][0]['Uri'])) {
            echo '<meta name="og:image" content="' . $post->boat['Images'][0]['Uri'] . '" />' . "\n";
        }
    }

    /**
     * Canonical link can be an issue for virtual pages.
     * @param string $str
     */
    public function showooms_remove_meta_canonical($str) {
        return '';
    }
    
    /**
     * Add custom meta description
     * 
     * @param string $str
     * @return string
     */
    public function showooms_add_meta_description($str) {
        global $post;
        
        if($post->post_name == 'showroom-details') {
            if(!empty($post->boat['GeneralBoatDescription']) && is_array($post->boat['GeneralBoatDescription'])) {
                $str = htmlentities(strip_tags(current($post->boat['GeneralBoatDescription'])));
            }
        }
        
        return $str;
    }    
    
    /**
     * Init with lang support
     */
    public function showrooms_init() {
        add_filter( 
            'pre_update_option_' . OEM_SHOWROOMS_PREFIX . 'import_frequency', 
            array($this,'showrooms_update_field_import_frequency'), 10, 2 
        );
        load_plugin_textdomain( 'plugin-oem-showrooms', false, basename(dirname(__FILE__) . '/..') . '/lang/' );
    }
    
    
    /**
     * Plugin activation
     */
    public function showrooms_activation() {
        error_log('plugin-oem-showrooms activated');
        
        $detail_rewrite_syntax = get_option(OEM_SHOWROOMS_PREFIX . 'detail_url', false);
        if(empty($detail_rewrite_syntax)) {
            update_option(OEM_SHOWROOMS_PREFIX . 'detail_url', '[Year]-[MakeModel]-[DocumentID]');       
        }
    }    
    
    /**
     * On deactivation, remove all functions from the scheduled action hook.
     */
    public function showrooms_deactivation() {
        wp_clear_scheduled_hook( 'showrooms_import_event' );
    
        error_log('plugin-oem-showrooms deactivated');
    }
    
    
    /**
     * URL Rewrites for brands page, models page and details page
     */
    public function oem_showrooms_add_rewrite_rules($rules) {
    
        $new_rules = array(); 
        
        $landing_page_slug = Oem_Showrooms_Settings::get_landing_page_slug();
        $detail_key = $landing_page_slug . '/' . get_option(OEM_SHOWROOMS_PREFIX . 'detail_url');
    
        // detail page rewrite rule
        $search = array('[Year]', '[MakeModel]', '[DocumentID]');
        $replace = array('([0-9]+)', '([A-Za-z0-9-]+)', '([0-9]+)');
        $detail_key = str_replace($search, $replace, $detail_key, $count) . '$';
        $detail_page_id = get_option(OEM_SHOWROOMS_PREFIX . 'detail_page_id');
    
        $new_rules[$detail_key] = 'index.php?page_id=' . $detail_page_id . 
            '&DocumentID=$matches[' . $count . ']';
        
        // brand page with filters
        $brand_page_filtered = $landing_page_slug . '/([A-Za-z0-9-]+)/year-([A-Za-z0-9-]+)/type-([A-Za-z0-9-%]+)$';
        $new_rules[$brand_page_filtered] = 'index.php?pagename=' . $landing_page_slug . '/$matches[1]&ModelYear=$matches[2]&BoatClassCode=$matches[3]';
        
        $rules = $new_rules + $rules;
    
        return $rules;
    }   

    public function oem_showrooms_add_query_vars($aVars) {
        $aVars[] = "OemDebug";
        $aVars[] = "DocumentID";
        $aVars[] = "OwnerPartyID";
        $aVars[] = "BoatClassCode";
        $aVars[] = "ModelYear";
    
        return $aVars;
    } 

    /**
     * Add weekly, bi-weekly and monthly cron options
     */
    public function cron_add_weekly( $schedules ) {
        // Adds once weekly to the existing schedules.
        $schedules['weekly'] = array(
                'interval' => 604800,
                'display' => __( 'Once Weekly', 'plugin-oem-showrooms' )
        );
        return $schedules;
    }
    
    public function cron_add_biweekly( $schedules ) {
        // Adds once weekly to the existing schedules.
        $schedules['biweekly'] = array(
                'interval' => 1209600,
                'display' => __( 'Once Bi-Weekly', 'plugin-oem-showrooms' )
        );
        return $schedules;
    }
    
    public function cron_add_monthly( $schedules ) {
        // Adds once weekly to the existing schedules.
        $schedules['monthly'] = array(
                'interval' => 2419200,
                'display' => __( 'Once Bi-Weekly', 'plugin-oem-showrooms' )
        );
        return $schedules;
    }
    
    /**
     * Saving import frequency should reset the import cron
     */
    public function showrooms_update_field_import_frequency( $new_value, $old_value ) {
        $selectedSchedule = $new_value;
    
        $schedules = wp_get_schedules();
        $nextScheduled = time() + intval($schedules[$new_value]['interval']);
    
        wp_clear_scheduled_hook( 'showrooms_import_event' );
        wp_schedule_event($nextScheduled, $selectedSchedule, 'showrooms_import_event');
    
        return $new_value;
    }  

    /**
     * Test connectivity to search API
     *
     * @param array $brand_party_ids
     * @return boolean
     */
    public function showrooms_test_oem_results($brand_party_ids = array())
    {
        $mmp_api_key = get_option('mmp_api_key');
        $api = new Mmp_API($mmp_api_key);
    
        if(!empty($brand_party_ids)) {
            foreach($brand_party_ids as $party_id) {
                $api->set_party_id($party_id);
                $api->set_current_page(1);
                $api->set_fields('DocumentID');
                $api->set_results_per_page(1);
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
     * Pull the PDF of boat details when format=pdf param is specified
     */
    public function oem_showrooms_template_redirect() {
        global $wp_query;
        
        $is_pdf = (isset($_REQUEST['format']) && $_REQUEST['format'] == 'pdf') ||
        (isset($_REQUEST['pdf']) && $_REQUEST['pdf'] == 1);        
        
        if ( $is_pdf && 
             isset($wp_query->query['DocumentID']) &&
             $wp_query->post->post_name == 'showroom-details') 
        {
                    
            $boat = Showrooms_Helper::get_boat_details($wp_query->query['DocumentID']);
            $boat['referer'] = 'showrooms';
            $categories = !empty($boat['BoatClassCode']) ? implode(', ', $boat['BoatClassCode']) : '-';
            $title = $boat['ModelYear'] . ' ' . $boat['MakeString'] . ' ' . $boat['Model'] . ' - ' . $boat['DocumentID'];
            
            if(!defined('CORE_PLUGIN_PATH')) {
                die('Core plugin disabled!');
            }
            
            ob_start();
            include (get_template_directory() . '/templates/pdf/boat-details.php');
            $html = ob_get_clean();
            
            if(!empty($_REQUEST['debug'])) {
                echo $html;
            }
            else {
                $dompdf = new Dmm_Pdf();
                $dompdf->get_pdf($html, $title . '.pdf');
            }
            
            exit;            
        }
    }
    
    /**
     * Add custom logo meta box for brand pages
     */
    public function oem_showrooms_add_meta_box() {
        global $post;
        
        $screens = array( 'page' );
        $brand_id = get_post_meta($post->ID, 'oem_showrooms_brand_id', true);
        
        // no showroom options if this isnt a brand page
        if(empty($brand_id)) {
            return $brand_id;
        }
        
        wp_register_script('oem-showrooms-admin', OEM_SHOWROOMS_BASE_URL . '/resources/js/admin.js', array('jquery','media-upload','thickbox'));
        wp_enqueue_script('oem-showrooms-admin');
        
        add_meta_box(
            'oem_showrooms_page_options',
            __( 'Manufacturer Logo', 'plugin-oem-showrooms' ),
            array($this, 'oem_showrooms_meta_box_callback'),
            'page',
            'side'
        );     
    }
    
    /**
     * Prints the box content.
     *
     * @param WP_Post $post The object for the current post/page.
     */
    public function oem_showrooms_meta_box_callback( $post ) 
    {  
        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'oem_showrooms_meta_box', 'oem_showrooms_meta_box_nonce' );
    
        $is_custom_logo = false;
        $logo = get_post_meta($post->ID, 'oem_showrooms_brand_logo', true);
        if(!empty($logo)) {
            $logo = '<img src="' . $logo . '" alt="" width="200" />';
            $is_custom_logo = true;
        }
        else {
            $brand_id = get_post_meta($post->ID, 'oem_showrooms_brand_id', true);
            $logo = Showrooms_Helper::the_brand_logo($brand_id);
        }
        
        $html = '<p class="description">';
        $html .= __('Do you have your own logo for this brand? Optimal size for brand logos is 235 X 95 pixels', 'plugin-oem-showrooms');
        $html .= '</p>';
        $html .= '<input id="oem_showrooms_brand_logo" type="hidden" size="36" name="oem_showrooms_brand_logo" value="" /><br />';
        $html .= '<input id="upload_image_button" type="button" value="' . __('Upload Logo', 'plugin-oem-showrooms') . '" />';
        $html .= '<br /><br /><span id="logo-container">' . $logo . '</span><br /><br />';
        
        if($is_custom_logo) {
            $html .= '<a id="removeBrandLogo" href="javascript:void(0)">' . __('Remove Custom Logo', 'plugin-oem-showrooms') . '<a>';
        }
        
        echo $html;
    }  
       
    /**
     * Extend save post to save custom brand logo
     * 
     * @param int $id
     */
    public function oem_showrooms_save_post($id) 
    {  
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $id;
        }

        if(isset($_POST['post_type']) && 'page' == $_POST['post_type'] && !current_user_can('edit_page', $id)) {
            return $id;
        }        
        
        if(isset($_REQUEST['oem_showrooms_brand_logo']) && !empty($_REQUEST['oem_showrooms_brand_logo'])) {
            delete_post_meta($id, 'oem_showrooms_brand_logo');
            add_post_meta($id, 'oem_showrooms_brand_logo', $_REQUEST['oem_showrooms_brand_logo']);
        }

    }
    
    /**
     * Remove custom logo from brand page
     */
    public function showrooms_remove_logo()
    {
        $post_id = intval( $_POST['post_id'] );
        if(empty($post_id)) {
            wp_die();
        }
        
        delete_post_meta($post_id, 'oem_showrooms_brand_logo');
        $brand_id = get_post_meta($post_id, 'oem_showrooms_brand_id', true);
        $default_logo = Showrooms_Helper::the_brand_logo($brand_id);
        
        echo $default_logo;
        wp_die();
    }
     
    
    
}