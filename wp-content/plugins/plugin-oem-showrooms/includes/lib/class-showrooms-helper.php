<?php
/**
 * Showrooms_Helper
*
* @package oem-showrooms
*
* @version 0.9
* @author Tim Hysniu
* @link https://github.dominionenterprises.com/DMM-CW-US/plugin-oem-showrooms
*/

/**
 * Showrooms_Helper class
*
*/
class Showrooms_Helper {

    public static $mmp_api = null;

    /**
     * Get image as HTML img
     *
     * @param string $url
     * @param string $class
     * @param string $alt
     * @return string
     */
    public static function get_image($url, $class = '', $alt = '')
    {
        $url = !empty($url) ? $url : get_template_directory_uri() . '/img/no-photo.jpg';

        return '<img src="'. $url .'" alt="' . $alt . '" class="' . $class . '" />';
    }

    /**
     * Get thumbnail image as HTML img
     *
     * @param string $url
     * @param string $class
     * @param string $alt
     * @return string
     */
    public static function get_thumbnail($url, $class = 'img-thumbnail', $alt = '')
    {
        $url = !empty($url) ? $url : get_template_directory_uri() . '/img/no-photo.jpg';

        return '<img src="'. $url .'" alt="' . $alt . '" class="' . $class . '" />';
    }

    private static function get_mmp_api()
    {
        if(is_null(self::$mmp_api)) {
            $mmp_api_key = get_option('mmp_api_key');
            self::$mmp_api = new Mmp_API($mmp_api_key);
        }

        return self::$mmp_api;
    }

    /**
     * Get boat details
     *
     * @param number $document_id
     * @return array
     */
    public static function get_boat_details($document_id)
    {
        $api = self::get_mmp_api();

        $api->set_document_id($document_id);
        $api->add_field('Owner');
        $api->set_fields(null);
        $results = $api->get_results();

        $boat_details = !empty($results['results']) && is_array($results['results']) ?
            current($results['results']) :
            array();

        if(!empty($boat_details['Owner'])) {
            $owner_party_id = $boat_details['Owner']['PartyId'];
            if(!empty($owner_party_id)) {
                $boat_details['logo'] = self::the_custom_brand_logo($owner_party_id);
            }
        }

        return $boat_details;
    }

    public static function get_current_model_years()
    {
        $default_years = date('Y') . ',' .  (intval(date('Y')) + 1) . ',' . (intval(date('Y')) + 2);
        return $default_years;
    }

    /**
     * Get make models from party id
     *
     * @param number $ID
     * @return array
     */
    public static function get_make_models($ID, &$party_id)
    {
        global $wp_query;

        $class_search = false;

        $api = self::get_mmp_api();
        $party_id =  get_post_meta( $ID, OEM_SHOWROOMS_PREFIX . 'brand_id', true );

        // this is what customer chose to ignore
        $excludes = Showrooms_Helper::get_brand_excludes($party_id);

        $api->set_party_id($party_id);
        $api->set_fields('DocumentID,BoatClassCode,Images,MakeString,ModelYear,Model,DesignerName,GeneralBoatDescription,BoatClassCode');
        $api->set_facets('BoatClassCode');
        $api->set_sort_by('NormNominalLength', 'desc');
        $api->set_results_per_page(200);
        $api->set_current_page(1);

        $modelYearFilter = !empty($wp_query->query['ModelYear']) && $wp_query->query['ModelYear'] != 'all' ?
            intval($wp_query->query['ModelYear']) :
            self::get_current_model_years();
        $api->add_filter('ModelYear', $modelYearFilter);
        $boat_class = isset($wp_query->query['BoatClassCode'])?$wp_query->query['BoatClassCode']:'';
        if(!empty($boat_class) && $boat_class != 'all') {
            $boat_class = urldecode($boat_class);
            $boat_class = str_replace('-', ' ', $boat_class);
            $api->add_filter('BoatClassCode', $boat_class);
            $class_search = true;
        }

        $results = $api->get_results();

        // slot results into categories
        if(!empty($results['facets']['BoatClassCode'])) {

            $max_per_group = $class_search ? 400 : 12;

            // initialize type array
            $results['types'] = array();
            foreach($results['facets']['BoatClassCode'] as $type => $count) {
                if(in_array($type, $excludes['category'])) continue;
                $results['types'][$type] = array();
            }

            $listing_ids = array();
            foreach($results['results'] as $boat) {
                $classes = $boat['BoatClassCode'];
                if(!empty($classes) && is_array($classes)) {
                    foreach($classes as $class) {

                        // this category was excluded by admin
                        if(!isset($results['types'][$class]) && !$class_search) {
                            continue;
                        }

                        // filter by class is set
                        if($class_search && $class != $boat_class) {
                            continue;
                        }

                        // dont show same result in multiple categories
                        if(in_array($boat['DocumentID'], $listing_ids)) {
                            continue;
                        }

                        // this id was ignored by admin
                        if(in_array($boat['DocumentID'], $excludes['id'])) {
                            continue;
                        }

                        // add this only if we have not exceeded max results per group
                        if(count($results['types'][$class]) < $max_per_group ) {
                            $listing_ids[] = $boat['DocumentID'];
                            $results['types'][$class][] = $boat;
                        }
                    }
                }
            } // foreach results


        }

        unset($results['results']);

        return $results;
    }

    /**
     * Get more models from this make

     * @param number $party_id
     * @param number $current_document_id
     * @return array
     */
    public static function more_from_make($party_id, $make, $current_document_id = 0) {
        $output = array();
        $api = self::get_mmp_api();

        $api->set_party_id($party_id);
        $api->add_filter('MakeString', $make);
        $api->set_fields('DocumentID,Images,MakeString,ModelYear,Model,DesignerName,BoatClassCode');
        $api->set_sort_by('ModelYear', 'desc');
        $api->set_results_per_page(5);
        $api->set_current_page(1);
        $api->set_document_id(null);

        $results = $api->get_results();

        if(!empty($results['results']) && is_array($results['results'])) {
            foreach($results['results'] as $boat) {
                if($boat['DocumentID'] != $current_document_id) {
                    $output[] = $boat;
                }
            }
        }

        return $output;
    }

    /**
     * Returns first boat image as html img
     *
     * @param array $boat
     * @param string $thumbnail
     * @return string
     */
    public static function get_boat_image($boat, $thumbnail = false) {
        $img = '';
        if(isset($boat['Images']) && !empty($boat['Images'])) {
            $firstImg = current($boat['Images']);
            $img = '<img src="' . $firstImg['Uri'] . '" class="img-responsive'. ($thumbnail ? ' ' : '') .'" alt="'.
                $boat["ModelYear"] . ' ' . $boat['MakeString'] . ' ' . $boat['Model'] .'" />';
        }

        return $img;
    }


    /**
     * Get boat id and category excludes for a brand
     *
     * @param int $party_id
     * @return array
     */

    public static function get_brand_excludes($party_id)
    {
        $exclude_string = get_option(OEM_SHOWROOMS_PREFIX . 'exclude_' . $party_id);
        $excludes = array('id' => array(), 'category' => array());
        if(strlen($exclude_string) > 0) {
            $exclude_rules = explode(',', $exclude_string);
            foreach($exclude_rules as $rule) {
                if(is_numeric($rule)) {
                    $excludes['id'][] = $rule;
                }
                else {
                    $excludes['category'][] = $rule;
                }
            }
        }

        return $excludes;
    }

    public static function the_custom_brand_logo($party_id = 0)
    {
        $logo = '';
        $custom_logo = '';

        // get brand page id
        $page_id = 0;
        if($party_id) {
            $query = "SELECT post_id FROM wp_postmeta WHERE meta_key = 'oem_showrooms_brand_id' AND meta_value = " . intval($party_id);
            $results = $GLOBALS['wpdb']->get_results( $query, ARRAY_A );
            if(!empty($results)) {
                $page_id = $results[0]['post_id'];
            }
        }
        else {
            global $post;
            $page_id = $post->ID;
        }

        // get custom logo if any
        if(!empty($page_id)) {
            $logo = get_post_meta($page_id, 'oem_showrooms_brand_logo', true);
        }

        // if no custom logo get default one from IMT
        if(empty($logo)) {
            $logo = self::the_brand_logo($party_id, true);
            $logo = str_replace(" ","%20", $logo);
        }

        return '<img class="brand-logo" src=' . $logo . ' />';
    }


    /**
     * Returns brand logo as HTML img.
     * If brand_id is not specified load it from page
     *
     * @param number $brand_id
     * @return string
     */
    public static function the_brand_logo($brand_id = 0, $url_only = false)
    {
        global $post;
        $logo = '';

        if(empty($brand_id)) {
            $brand_id = get_post_meta($post->ID, 'oem_showrooms_brand_id', true);
        }

        $brands = json_decode(get_option(OEM_SHOWROOMS_PREFIX . 'brands'), 1);

        if(empty($brand_id) || empty($brands)) {
            return $logo;
        }

        foreach($brands as $brand) {
            if($brand['id'] == $brand_id) {
                $logo = $brand['logo'];
                break;
            }
        }

        // no custom logo or logo in IMT; set static default one
        if(empty($logo)) {
            $logo = get_template_directory_uri() . '/img/manifacturer.jpg';
        }

        if($url_only) {
            return $logo;
        }

        return '<img class="brand-logo" src=' . $logo . ' />';
    }

    /**
     * Get all published brands that should display
     * on homepage
     */
    public static function get_home_brands($limit = null)
    {
        // get all non-hidden brands
        $brands = json_decode(get_option(OEM_SHOWROOMS_PREFIX . 'brands'), 1);
        $active_pages = array();

        if(!empty($brands)){

            foreach($brands as $brand_key => &$brand_array) {
                $page_id = get_option(OEM_SHOWROOMS_PREFIX . 'brand_page_id_' . $brand_key, 1);
                if(is_numeric($page_id)) {
                    $active_pages[] = $page_id;
                }
            }
        }

        $query = "SELECT * FROM wp_postmeta WHERE meta_key = 'oem_showrooms_brand_id'";

        if ( is_numeric($limit) ) {
            $query .= " LIMIT " . $limit;
        }

        // get logos
        $results = $GLOBALS['wpdb']->
            get_results( $query, ARRAY_A );

        // load and filter out hidden results
        foreach($results as $key => &$brand) {
            $logo = get_post_meta($brand['post_id'], 'oem_showrooms_brand_logo', true);
            if(empty($logo)) {
                $logo = self::the_brand_logo($brand['meta_value'], true);
            }

            $brand['logo'] = self::get_image($logo, 'center-block img-responsive');
            $brand['url'] = get_permalink($brand['post_id']);

            // hide hidden
            $hidden = intval(!in_array($brand['post_id'], $active_pages));
            if($hidden) {
                unset($results[$key]);
            }
        }

        // determine bootstrap class
        $results = array_values($results);
        for($i=0; $i < count($results); $i++) {
            $results[$i]['column_size'] = self::get_home_brands_grid_size($results, $i);
        }

        $results = empty($results) || !is_array($results) ? array() : $results;

        return $results;
    }

    private static function get_home_brands_grid_size($brands, $index) {
        $count = count($brands);
        $groups = array_chunk($brands, 4);
        $num_groups = count($groups);
        $current_group_index = floor($index / 4);
        $current_group_count = count($groups[$current_group_index]);
        $last_group_index = count($groups) - 1;


        if($num_groups > 1 && count($groups[$last_group_index]) < 2 && $count % 3 !== 0) {
            $groups[$last_group_index][] = array_pop($groups[$last_group_index-1]);
            $current_group_index = floor($index / 3);
            $current_group_count = count($groups[$current_group_index]);
        }

        if($count % 3 == 0) {
            $cell_size = 4;
        }
        elseif($count % 4 == 0) {
            $cell_size = 3;
        }
        elseif($current_group_count % 3 == 0) {
            $cell_size = 4;
        }
        elseif($current_group_count % 4 == 0) {
            $cell_size = 3;
        }
        elseif($current_group_count % 2 == 0) {
            $cell_size = 6;
        }
        else {
            $cell_size = 12;
        }

        return $cell_size;
    }

    /**
     * Get settings dropdown with mapped brand page
     *
     * @todo Bring back drop downs with all brand pages!
     * @param int $id
     * @param string $selected_post_id
     * @param string $template_file
     */
    public static function get_showroom_brands_dropdown($id, $selected_post_id, $brand_id, $template_file)
    {
        $query = 'post_type=page&meta_key=_wp_page_template&meta_value=' . $template_file;
        $query .= '&meta_key=oem_showrooms_brand_id&meta_value=' . $brand_id;
        $pages = query_posts($query);

        $html = '<select name="' . $id . '" id="' . $id . '">';
        $html .= '<option value="EMPTY" '.
            (empty($selected) || $selected_post_id == 'EMPTY' ? 'selected' : '') .'>-- ' .
            __('Hide this brand', 'plugin-oem-showrooms') . ' --</option>';

        foreach($pages as $page) {

            $selected = ($selected_post_id == $page->ID ? 'selected' : '');
            $html .= '<option class="level-0" ' . $selected . ' value="' . $page->ID . '">' . $page->post_title . '</option>';
        }
        $html .= '</select>';

        return $html;
    }


}
