<?php
class Inventory_Helper {
    
    public static $MEASUREMENT_TYPE_METER = 'm';
    public static $MEASUREMENT_TYPE_FEET = 'ft';
    
    private static $detail_page_permalink = '';
    private static $permalink_params = array();
    private static $feet2metres = 0.3048;
    private static $length_formats = array();   
    private static $default_currency = null;
    private static $default_length_unit = null;
    private static $units_of_measure = null;
    
    /**
     * Get URL of boat details page
     * 
     * @param array $boat
     * @return string
     */
    public static function get_details_page_url($boat)
    {
        $location_slug = self::get_location_slug($boat);
        $url = self::get_detail_page_permalink();
        
        if(!empty($boat)) {
            $url .= $boat['ModelYear'] . '-' . self::slugify($boat['MakeString']) . '-';
            $url .= self::slugify($boat['Model']);
            
            if(!empty($location_slug) && !empty($url)) {
                $url .= '-' . $location_slug;
            }

            $url .= '-' . self::slugify($boat['DocumentID']);         
        }
        $url .= '/';
        
        if(!empty($_GET['currency'])) {
            $url .= '?currency=' . $_GET['currency'];
        }
         
        return $url;   
    }
    
    /**
     * Get location slug that can be inserted in 
     * boat details URL
     * 
     * @param array $boat
     * @return string
     */
    private static function get_location_slug($boat)
    {
        $location_format = get_option('inventory_plugin_location_radios', 'city/country');
        $slug = '';
        
        if(empty($location_format) || empty($boat['BoatLocation'])) {
            return $slug;
        }
        
        if(strstr($location_format, 'city') && !empty($boat['BoatLocation']['BoatCityName']) && $boat['BoatLocation']['BoatCityName'] != 'Unknown') {
            $slug .= self::slugify($boat['BoatLocation']['BoatCityName']);
        }   
        
        if(strstr($location_format, 'state') && !empty($boat['BoatLocation']['BoatStateCode']) && $boat['BoatLocation']['BoatStateCode'] != 'Unknown') {
            $states = new States();
            $slug = rtrim($slug, '-');
            $slug .= (!empty($slug) ? '-' : '');
            $slug .= self::slugify($states->getStateName($boat['BoatLocation']['BoatStateCode']));
        }        
        
        if(strstr($location_format, 'country') && !empty($boat['BoatLocation']['BoatCountryID']) && $boat['BoatLocation']['BoatCountryID'] != 'Unknown') {
            $countries = new Countries();
            $slug = rtrim($slug, '-');
            $slug .= (!empty($slug) ? '-' : '');            
            $slug .= self::slugify($countries->getCountryName($boat['BoatLocation']['BoatCountryID']));
        }
        
        return $slug;
    }
    
    /**
     * Get inventory search page action url
     */
    public static function get_quick_search_url($hide_hostname = false)
    {
        $search_page_id = get_option(INVENTORY_PREFIX . 'search_page_id');
        $permalink = get_permalink($search_page_id);
        
        if($hide_hostname) {
            $permalink = str_replace(home_url(), '', $permalink);
        }
        
        return $permalink;
    }
    
    /**
     * Get location string for a boat
     * 
     * @param array $boat
     * @return string
     */
    public static function get_location_string($boat) 
    {
        $location_format = get_option('inventory_plugin_location_radios', 'city/country');
        $location_string = '';
        
        if(!isset($boat['BoatLocation'])) {
            return $location_string;
        }
        
        $countries = new Countries();
        $states = new States();      
        
        switch ($location_format) {
            case 'city/state':
                $city_string = !empty($boat['BoatLocation']['BoatCityName']) && $boat['BoatLocation']['BoatCityName'] != 'Unknown' ?
                    $boat['BoatLocation']['BoatCityName'] : '';
                $state_string = !empty($boat['BoatLocation']['BoatStateCode']) && $boat['BoatLocation']['BoatStateCode'] != 'Unknown' ?
                    $states->getStateName($boat['BoatLocation']['BoatStateCode']) : '';
                
                $location_string .= $city_string;
                $location_string .= (!empty($state_string) ? ', ' . $state_string : '');
                
                break;
                
            case 'city/state/country':
                $city_string = !empty($boat['BoatLocation']['BoatCityName']) && $boat['BoatLocation']['BoatCityName'] != 'Unknown' ?
                    $boat['BoatLocation']['BoatCityName'] : '';
                $country_string = !empty($boat['BoatLocation']['BoatCountryID']) && $boat['BoatLocation']['BoatCountryID'] != 'Unknown' ?
                    $countries->getCountryName($boat['BoatLocation']['BoatCountryID']) : '';
                $state_string = !empty($boat['BoatLocation']['BoatStateCode']) && $boat['BoatLocation']['BoatStateCode'] != 'Unknown' ?
                    $states->getStateName($boat['BoatLocation']['BoatStateCode']) : '';
                
                $location_string .= $city_string;
                $location_string .= (!empty($location_string) ? ', ' : '');
                $location_string .= $state_string;
                $location_string .= (!empty($location_string) && !empty($state_string) ? ', ' : ' ');
                $location_string .= $country_string;              
                break;
                
            case 'country':
                $location_string .= $countries->getCountryName($boat['BoatLocation']['BoatCountryID']);
                break;
                
            default:
                $city_string = !empty($boat['BoatLocation']['BoatCityName']) && $boat['BoatLocation']['BoatCityName'] != 'Unknown' ?
                    $boat['BoatLocation']['BoatCityName'] : '';
                $country_string = !empty($boat['BoatLocation']['BoatCountryID']) && $boat['BoatLocation']['BoatCountryID'] != 'Unknown' ?
                    $countries->getCountryName($boat['BoatLocation']['BoatCountryID']) : '';                
                
                $location_string .= $city_string;
                $location_string .= (!empty($location_string) ? ', ' : '');
                $location_string .= $country_string;
                
            if(empty($location_string)) {
                $location_string = __('Unknown Country', 'inventory-plugin');
            }
        }
        
        return $location_string;
    }
    
    public static function get_length_string_both_units($boat, $key) {
        $output = '';
        
        $show_feet = Inventory_Helper::has_measurement_type('ft');
        $show_meters = Inventory_Helper::has_measurement_type('ft');
        
        $uom = get_option('inventory_plugin_uom', '');
        if($uom == 'Imperial-UK') {
            $show_feet = true;
        }
        
        if($show_feet) {
            $output .= Inventory_Helper::get_length_string($boat, 'ft', $key);
        }
        
        if($show_meters) {
            if(!empty($output)) {
                $output .= ' / ';
            }
            $output .= Inventory_Helper::get_length_string($boat, 'm', $key);
        }        
        
        return $output;
    }
    
    /**
     * Get price string for a boat
     * 
     * @param array $boat
     * @return string
     */
    public static function get_price_string($boat)
    {
        $priceStr = '';
        if (array_key_exists('Price', $boat) && !empty($boat['Price']) && $boat['SalesStatus'] != 'Sold' && $boat['SalesStatus'] != 'Sale Pending') {
            $priceArr = explode(' ', $boat['Price']);
            $price = number_format($priceArr[0]);
            $curr = $priceArr[1];
            $currencies = new Currencies();
            $symbol = $currencies->getSymbol($curr);
            $priceStr = $symbol . $price . " ";
        } else if ($boat['SalesStatus'] == 'Sale Pending') {
            $priceStr = __("Sale Pending", 'plugin-inventory');
        } else if ($boat['SalesStatus'] == 'Sold') {
            $priceStr = __("Sold", 'plugin-inventory');
        } else {
            $priceStr = __("Call for Price", 'plugin-inventory');
        }  
        
        return $priceStr;
    }
    
    /**
     * Get supported measurement types
     * 
     * @return array
     */
    public static function get_measurement_types()
    {
        if(empty(self::$length_formats)) {
            $supported_formats = get_option( 'inventory_plugin_length_checkboxes' );
            foreach($supported_formats as $format) {
                switch($format) {
                    case 'meters':
                        self::$length_formats[$format] = 'm';
                        break;
                    case 'feet':
                        self::$length_formats[$format] = 'ft';
                        break;
                    default:
                }
            }
        }
        
        return self::$length_formats;
    }
    
    /**
     * Is this measurement type selected in settings
     *
     * @param string $measurement_type
     * @return number
     */
    public static function has_measurement_type($measurement_type) {
        $types = self::get_measurement_types();
    
        $has_type = array_search($measurement_type, $types) !== FALSE;
    
        return intval($has_type);
    }
    
    /**
     * Get boat length in selected measurement type
     *
     * @param array $boat
     * @param string $lengthStr
     */
    public static function get_length_string($boat, $measurement_type = 'ft', $key = 'NominalLength')
    {
        $lengthStr = '';
        $env = new Environment();
    
        if(array_key_exists($key, $boat))
        {
            $NominalLength = explode(' ', $boat[$key]);
            if ($NominalLength[1] == 'ft') {
                $NominalLengthFt = $NominalLength[0];
                $NominalLengthMt = number_format($NominalLength[0] * self::$feet2metres, 2);
            } else {
                $NominalLengthMt = $NominalLength[0];
                $NominalLengthFt = number_format($NominalLength[0] / self::$feet2metres, 2);
            }
        }
    
        switch($measurement_type) {
            case self::$MEASUREMENT_TYPE_FEET:
                $lengthStr .= $NominalLengthFt . ' ' . self::$MEASUREMENT_TYPE_FEET;
                break;
            case self::$MEASUREMENT_TYPE_METER:
                $lengthStr .= $NominalLengthMt . ' ' . self::$MEASUREMENT_TYPE_METER;
                break;
        }
    
        return $lengthStr;
    }    
    
    /**
     * Get condition, category, make, model, country, state, city from URL
     *
     * @param string $param
     * @return string
     */
    public static function get_search_permalink_params($key = NULL, $default_value = '')
    {
        $params = self::get_search_permalink_params_array();
        
        return isset($params[$key]) ? $params[$key] : $default_value;
    } 
    
    /**
     * Parse wp_query for search and get filters
     * 
     * @return array
     */
    public static function get_search_permalink_params_array()
    {
        $params = array(
            'condition' => '',
            'make' => '',
            'model' => '',
            'category' => '',
            'country' => '',
            'state' => '',
            'city' => '',
        );
        
        $category_query = isset($GLOBALS['wp_query']->query['category_query']) ? $GLOBALS['wp_query']->query['category_query'] : '';
        $makemodel_query = isset($GLOBALS['wp_query']->query['makemodel_query']) ? $GLOBALS['wp_query']->query['makemodel_query'] : '';
        $location_query = isset($GLOBALS['wp_query']->query['location_query']) ? $GLOBALS['wp_query']->query['location_query'] : '';
        
        // category
        if(empty($category_query)) {
            return $params;
        }
        
        $category_params = explode('-', $category_query);
        $params['condition'] = isset($category_params[0]) && $category_params[0] != 'all' ?
            $category_params[0] : '';
        $params['category'] = isset($category_params[1]) && $category_params[1] != 'all' ?
            $category_params[1] : '';        
        
        // make/model
        if(empty($makemodel_query)) {
            return $params;
        }   
        
        $make_params = explode('-', $makemodel_query);
        $params['make'] = isset($make_params[0]) && $make_params[0] != 'all' ? 
            self::prepare_for_display($make_params[0]) : '';
        $params['model'] = isset($make_params[1]) && $make_params[1] != 'all' ? 
            self::prepare_for_display($make_params[1]) : '';
        
        // location
        if(empty($location_query)) {
            return $params;
        }
        
        $pieces = explode('-', $location_query);
        if(isset($pieces[2]) && ($pieces[2] == 'US' || $pieces[2] == 'CA')) {
            $params['country'] = $pieces[2];
            $params['state'] = isset($pieces[1]) && $pieces[1] != 'all' ? $pieces[1] : '';
            $params['city'] = isset($pieces[0]) && $pieces[0] != 'all' ? self::prepare_for_display($pieces[0]) : '';
        }
        elseif(count($pieces) == 2) {
            $params['country'] = isset($pieces[1]) && $pieces[1] != 'all' ? $pieces[1] : '';
            $params['city'] = isset($pieces[0]) && $pieces[0] != 'all' ? self::prepare_for_display($pieces[0]) : '';
        }
        
        return $params;
    }
    
    /**
     * Get previous page URL if available
     * 
     * @return string
     */
    public static function generate_previous_search_url() {
        $url = '';
        $per_page = (isset($_REQUEST['option']) && intval($_REQUEST['option']) > 0) ? intval($_REQUEST['option']) : 10;
        if(isset($_REQUEST['start']) && intval($_REQUEST['start']) > 0) {
            $previous_page = intval($_REQUEST['start']) / $per_page;
            $url = self::generate_search_url(array('page' => $previous_page, 'per_page' => $per_page), true);
        }

        return $url;   
    }
    
    /**
     * Get next page URL if available
     * 
     * @param number $max_results
     * @return string
     */
    public static function generate_next_search_url($max_results = 0) {
        $url = '';
        $per_page = (isset($_REQUEST['option']) && intval($_REQUEST['option']) > 0) ? intval($_REQUEST['option']) : 10;
        $current_page = (isset($_REQUEST['start']) && intval($_REQUEST['start']) > 0) ? (intval($_REQUEST['start']) / $per_page) + 1 : 1;
        $next_page = 2;
        $max_page = !empty($max_results) ? ceil($max_results / $per_page) : 1;
        
        if($max_page <= $current_page) {
            return $url;
        }
        elseif(isset($_REQUEST['start']) && intval($_REQUEST['start']) > 0) {
            $next_page = (intval($_REQUEST['start']) / $per_page) + 2;
            if($next_page > $max_results) {
                return $url;
            }
        }
        
        $url = self::generate_search_url(array('page' => $next_page, 'per_page' => $per_page), true);
        
        return $url;        
    }
    
    /**
     * Generate search URL using current URL and args provided
     * 
     * @param array $args
     * @return string $url
     */
    public static function generate_search_url($args = array(), $preserve_query = false) {
        
        $url_params = self::get_search_permalink_params_array();
        $request_params = array_merge($_REQUEST, array());
        
        foreach($args as $key => $val) {
            $url_params[$key] = $val;
        }
        
        $url = '';
        $url_category = '';
        $url_makemodel = '';
        $url_location = '';
        
        // category part
        $url_category .= !empty($url_params['condition']) ? $url_params['condition'] : 'all';
        $url_category .= '-';
        $url_category .= !empty($url_params['category']) ? $url_params['category'] : '';
        $url_category = rtrim($url_category, '-');
        
        // makemodel part
        $url_makemodel .= !empty($url_params['make']) ? self::prepare_for_url($url_params['make'], 'ucwords') : 'all';
        $url_makemodel .= '-';
        $url_makemodel .= !empty($url_params['model']) ? self::prepare_for_url($url_params['model']) : '';
        $url_makemodel = rtrim($url_makemodel, '-');
                
        // location part
        if(!empty($url_params['country']) || !empty($url_params['state']) || !empty($url_params['city'])) {
            if($url_params['country'] == 'US' || $url_params['country'] == 'CA') {
                $url_location .= !empty($url_params['city']) ? self::prepare_for_url($url_params['city']) : 'all';
                $url_location .= '-';
                $url_location .= !empty($url_params['state']) ? self::prepare_for_url($url_params['state']) : 'all';
                $url_location .= '-';
                $url_location .= $url_params['country'];
            }
            elseif(!empty($url_params['country']) && empty($url_params['state']) && empty($url_params['city'])
                       && !in_array($url_params['country'], array('US', 'CA')) ) {
                $url_location .= 'all-' . $url_params['country'];
            }
            elseif(!empty($url_params['country']) && !empty($url_params['city'])) {
                $url_location .= self::prepare_for_url($url_params['city']) . '--' . $url_params['country'];
            } 
            
            $url_location = rtrim($url_location, '-');
        }
        
        $url = $url_category . '/';
        if(!empty($url_location)) {
            $url .= $url_makemodel . '/' . $url_location . '/';
        }
        elseif(empty($url_location) && $url_makemodel != 'all') {
            $url .= $url_makemodel . '/';
        }
        
        if(isset($request_params['action'])) {
            unset($request_params['action']);
        }
        
        if(isset($request_params['data'])) {
            unset($request_params['data']);
        }     
        
        // each seach is a new search which resets to page 1
        if(isset($request_params['start'])) {
            unset($request_params['start']);
        }        
        
        if(isset($args['per_page']) && isset($args['page'])) {
            if(intval($args['page']) > 0) {
                $args['start'] = (intval($args['page']) - 1) * intval($args['per_page']);
            }
            
            unset($args['per_page']);
            unset($args['page']);
        }
        
        // query string
        $permalink_params = array('make', 'model', 'condition', 'category', 'country', 'state', 'city');
        $query_string = '';
        $query_params = array_merge($request_params, $args);
        
        foreach($query_params as $arg_key => $arg_value) {
            if(!empty($arg_value) && !in_array($arg_key, $permalink_params)) {
                switch($arg_key) {
                    case 'currency':
                        $default_currency = self::get_default_currency_symbol();
                        if($default_currency == $arg_value) {
                            continue;
                        }
                    case 'unit':
                        $default_unit = self::get_default_length_unit();
                        if($default_unit == $arg_value) {
                            continue;
                        }
                        
                    default:
                        $query_string .= $arg_key . '=' . $arg_value . '&';
                }
            }
        }
        
        if(!empty($query_string)) {
            $url .= '?' . rtrim($query_string, '&');
        }
        
        return self::get_quick_search_url(true) . $url;
    }
    
    /**
     * Retrieve ui formatted currencies selected in inventory settings
     * Format: array('$' => 'USD', ...)
     * 
     * @return array
     */
    public static function get_currencies() {
        $currencies_inventory_format = get_option( 'inventory_plugin_currency_checkboxes' );
        $currencies_ui = array();
        
        if(!empty($currencies_inventory_format)) {
            foreach($currencies_inventory_format as $currency_id) {
                $key = self::get_currency_label($currency_id);
                $value = self::get_currency_symbol($currency_id);
                $currencies_ui[$key] = $value;
            }
        }
        
        return $currencies_ui;
    }
    
    /**
     * Get currencies dropdown HTML
     * 
     * @param string $name
     * @param string $selected
     * @param string $additional_classes
     */
    public static function get_currency_dropdown($name, $selected = NULL, $additional_classes = '') {
        $selected = (isset($_REQUEST[$selected]) && !empty($_REQUEST[$selected])) ? $_REQUEST[$selected] : NULL;
        $currencies = self::get_currencies();
        $output = '';
        
        if(is_null($selected)) {
            $selected = self::get_default_currency_symbol();
        }
        
        if( count($currencies) > 1 ) {
            $output .= '<select id="' . $name . '" class="form-control filter-select ' . $additional_classes . '" name="' . $name . '">';
            foreach ($currencies as $key => $value) {
                $is_selected = ($selected == $value) ? 'selected="selected"' : '';
                $output .= '<option ' . $is_selected . ' id="form_unit_radios" type="radio" value="' . $value . '">' . $key . '</option>';
            }
            
            $output .= '</select>';            
        }
        else {
            foreach ($currencies as $key => $value) {
                $output .= '<div class="single-select">';
                $output .= $key;
                $output .= '<input type="hidden" id="currency" value="' . $value . '" />';
                $output .= '</div>'; 
            }
        }
        
        return $output;
    }
    
    /**
     * Get units of measurement dropdown HTML
     * 
     * @param string $name
     * @param string $selected
     * @return string
     */
    public static function get_length_dropdown($name, $selected = NULL, $additional_classes = '')
    {
        $selected = (isset($_REQUEST[$selected]) && !empty($_REQUEST[$selected])) ? $_REQUEST[$selected] : NULL;
        $units = self::get_measurement_types();
        $output = '';
        
        if(is_null($selected)) {
            $selected = self::get_default_length_unit();
        }        
        
        if( count($units) > 1 ) {
            $output .= '<select id="' . $name . '" class="form-control filter-select ' . $additional_classes . '" name="' . $name . '">';       
            foreach ($units as $key => $value) {
                $is_selected = ($selected == $key) ? 'selected="selected"' : '';
                $output .= '<option ' . $is_selected . ' id="form_unit_radios" type="radio" value="' . $key . '">' . $value . '</option>';
            }
        
            $output .= '</select>';
        } 
        else {
            foreach ($units as $key => $value) {
                $output .= '<div class="single-select">';
                $output .= $value;
                $output .= '<input type="hidden" id="' . $name . '" value="' . $key . '" />';
                $output .= '</div>';
            }
            
        } 
        
        return $output;
    }
    
    /**
     * Get facet deselector (X)
     * @param string $name
     * @return string
     */
    public static function get_facet_deselector($name) {
        $output = '';
        if(isset($_REQUEST[$name]) && !empty($_REQUEST[$name])) {
            $url = self::generate_search_url(array($name => '', true));
            $output = '<span><a href="' . $url . '">X</a></span>';
        }
        
        return $output;
    }
    
    /**
     * Get default currency symbol
     */
    public static function get_default_currency_symbol()
    {
        if(is_null(self::$default_currency)) {
            self::$default_currency = get_option('inventory_plugin_default_currency', 'dollar');
        }
    
        return self::get_currency_symbol(self::$default_currency);
    }   
    
    /**
     * Get default currency symbol
     */
    public static function get_default_currency_label()
    {
        if(is_null(self::$default_currency)) {
            self::$default_currency = get_option('inventory_plugin_default_currency', 'dollar');
        }
    
        return self::get_currency_label(self::$default_currency);
    } 
    
    /**
     * Get units of measure
     * Allowed options are the same as in provisioning
     */
    public static function get_units_of_measure($default = '')
    {
        if(is_null(self::$units_of_measure)) {
            self::$units_of_measure = get_option('inventory_plugin_uom', 'dollar');
            
            if(empty(self::$units_of_measure)) {
                self::$units_of_measure = $default;
            }
        }
    
        return self::$units_of_measure;
    }    
    
    /**
     * Get default length unit for search
     */
    public static function get_default_length_unit()
    {
        if(is_null(self::$default_length_unit)) {
            $uom = get_option('inventory_plugin_uom', 'Imperial-US');
            switch($uom) {
                case 'Imperial-US':
                    self::$default_length_unit = 'feet';
                    break;
                default:
                    self::$default_length_unit = 'meters';
            }
        }
    
        return self::$default_length_unit;
    }    
    
    /**
     * Get currency label HTML by inventory currency id
     * 
     * @param string $currency_id
     * @return string
     */
    private static function get_currency_label($currency_id) {
        $label = '';
        switch($currency_id) {
            case 'dollar':
                $label = '&dollar;';
                break;
            case 'pound':
                $label = '&pound;';
                break;
            case 'euro':
                $label = '&euro;';
                break;
        }
    
        return $label;
    }
    
    /**
     * Get currency symbol by inventory currency id
     * 
     * @param string $currency_id
     * @return string
     */
    private static function get_currency_symbol($currency_id) {
        $symbol = '';
        switch($currency_id) {
            case 'dollar':
                $symbol = 'USD';
                break;
            case 'pound':
                $symbol = 'GBP';
                break;
            case 'euro':
                $symbol = 'EUR';
                break;
        }
    
        return $symbol;
    } 
    
    /**
     * Get currency symbol by inventory currency id
     *
     * @param string $currency_id
     * @return string
     */
    private static function get_length_symbol($length_key) {
        $symbol = '';
        switch($length_key) {
            case 'meters':
                $symbol = 'mt';
                break;
            case 'feet':
                $symbol = 'ft';
                break;
        }
    
        return $symbol;
    }    
    
    /**
     * Get permalink of inventory boat detail page
     * 
     * @return string
     */
    private static function get_detail_page_permalink()
    {   
        if(empty(self::$detail_page_permalink)) {
            $search_page_id = get_option(INVENTORY_PREFIX . 'search_page_id', true);
            $search_page = get_post($search_page_id);
            self::$detail_page_permalink = get_permalink($search_page->ID);
        }
        
        return self::$detail_page_permalink;
    }
    
    /**
     * Slugify a text to url friendly format
     * 
     * @param string $text
     * @return string
     */
    private static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    
        // trim
        $text = trim($text, '-');
    
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
        // lowercase
        $text = strtolower($text);
    
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
    
        if (empty($text))
        {
            return 'n-a';
        }
    
        return $text;
    } 
    
    private static function prepare_for_url($text, $filter = '')
    {
        $s = array('-', ' ');
        $r = array('%7C', '+');
        
        if(!empty($filter)) {
            switch($filter) {
                case 'ucwords':
                    $text = ucwords($text);
                    break;
                default:
            }
        }        
        
        $formatted = str_replace($s, $r, $text);
    
        return $formatted;
    }
    
    private static function prepare_for_display($text)
    {
        $s = array('%7C', '+');
        $r = array('-', ' ');
    
        return str_replace($s, $r, $text);
    }    
       
}