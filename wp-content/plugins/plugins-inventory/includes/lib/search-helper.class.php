<?php
class Search_Helper {
    
	/**
	 * Load inventory results and append output as array
	 * to post object ($post->inventory)
	 * 
	 * @param object $post
	 */
	public function load_inventory_in_post(&$post)
	{   
        self::load_dependencies();
	    
	    $search = new Search();
	    $countries = new Countries();
	    $states = new States();
	    $currencies = new Currencies();	    
	    
	    $currency = !isset($_REQUEST['currency']) && !empty($_REQUEST['currency']) ?
	       $_REQUEST['currency'] :
	       Inventory_Helper::get_default_currency_symbol();
	    
	    $feet2metres = 0.3048;
	    
	    
	    if (isset($_GET['option']) && $_GET['option'] == '100') {
	        $results_per_page = 100;
	    } 
	    elseif(isset($_GET['option']) && $_GET['option'] == 'view-all') {
	        $results_per_page = 5000;
	    }
	    else { 
	        $results_per_page = 10; 
	    }
	    
	    //Get search Results
	    $criteria = !empty($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] : 's=1';

	    if(!isset($_REQUEST['currency']) || empty($_REQUEST['currency'])) {
	        $criteria .= '&currency=' .  Inventory_Helper::get_default_currency_symbol();
	    }
	    
	    $permalink_criteria = Inventory_Helper::get_search_permalink_params_array();
	    //print_r($permalink_criteria); die();
	    
	    if(isset($permalink_criteria['make']) && !empty($permalink_criteria['make'])) {
	        $criteria .= '&MakeString=' . $permalink_criteria['make'];
	    }
	    
	    if(isset($permalink_criteria['model']) && !empty($permalink_criteria['model'])) {
	        $criteria .= '&ModelExact=' . $permalink_criteria['model'];
	    }	   
	    
	    if(isset($permalink_criteria['category']) && !empty($permalink_criteria['category'])) {
	        $criteria .= '&category=' . ucwords($permalink_criteria['category']);
	    }
	    
	    if(isset($permalink_criteria['condition']) && !empty($permalink_criteria['condition'])) {
	        $criteria .= '&SaleClassCode=' . $permalink_criteria['condition'];
	    }
	    
	    if(isset($permalink_criteria['country']) && !empty($permalink_criteria['country'])) {
	        $criteria .= '&BoatCountryID=' . $permalink_criteria['country'];
	    }	    
	    
	    if(isset($permalink_criteria['state']) && !empty($permalink_criteria['state'])) {
	        $criteria .= '&BoatStateCode=' . $permalink_criteria['state']; 
	    }
	    
	    if(isset($permalink_criteria['city']) && !empty($permalink_criteria['city'])) {
	        $criteria .= '&BoatCityName=' . $permalink_criteria['city'];
	    }	
	    
	    $price_query = self::get_price_query();
	    if(!empty($price_query)) {
	        $criteria .= '&price=' . $price_query;
	    }
	    
	    $length_query = self::get_length_query();
	    if(!empty($length_query)) {
	        $criteria .= '&length=' . $length_query;
	    }	    
	    
	    $fields = NULL;
	    $facetFields = array('BoatClassCode', 'BoatCountryID', 'BoatStateCode', 'BoatCityName', 'MakeStringExact', 'ModelExact', 'SaleClassCode', 'BoatCategoryCode', 'ModelYear', 'price|0:99999999|usd', 'length|0:1000000|feet');
	    
	    if (isset($_GET['sort']) && $_GET['sort']) { 
	       $sort = $_GET['sort']; 
	    }
	    else { 
	        $sort='NormPrice|desc'; 
	    }
	    
	    $debug=false;
	    $params = array();
	    $results = NULL;
	    
	    $searchResult = $search->search($criteria, $fields, $facetFields, $results_per_page, $sort, $debug);
	    //print($criteria); die();
	    //print_r($searchResult);
	    
	    if (!array_key_exists($search->STATUS,$searchResult)) {
	        echo "<!-- An unknown error occurred -->";
	        echo "<div id=\"page-numbers\">An error was encountered</div>";
	    } 
	    else if ($searchResult[$search->STATUS] == $search->ERROR) {
	        // Output error message in the source but don't display anything
	        echo "<!-- Error";
	        print_r($searchResult[$search->BODY]);
	        echo "-->";
	    
	    } else {
	        //Get 1307number of results
	        $all_result=$searchResult[$search->BODY]['numResults'];
	        
	        if (array_key_exists($search->QUERYPARAMS, $searchResult)) {
	            $params = $searchResult[$search->QUERYPARAMS];
	        }
	        $results = $searchResult[$search->BODY]['results'];
	    }
	    
	    $manufacturer_array = array();
	    $model_array = array();
	    $condition_array = array();
	    $category_array = array();
	    $location_country_array = array();
	    $location_state_array = array();
	    $location_city_array = array();
	    
	    if (array_key_exists('facets', $searchResult[$search->BODY])) {
	        $manufacturer_array = ($searchResult[$search->BODY]['facets']['MakeStringExact']);
	    }
	    
	    if (array_key_exists('facets', $searchResult[$search->BODY])) {
	        $model_array = ($searchResult[$search->BODY]['facets']['ModelExact']);
	    }
	    
	    if (array_key_exists('facets', $searchResult[$search->BODY])) {
	        $condition_array = ($searchResult[$search->BODY]['facets']['SaleClassCode']);
	    }
	    
	    if (array_key_exists('facets', $searchResult[$search->BODY])) {
	        $category_array = ($searchResult[$search->BODY]['facets']['BoatCategoryCode']);
	    }
	    
	    if (array_key_exists('facets', $searchResult[$search->BODY])) {
	        $location_country_array = ($searchResult[$search->BODY]['facets']['BoatCountryID']);
	        if(isset($location_country_array[''])) {
	            unset($location_country_array['']);
	        }	        
	    }
	    
	    if (array_key_exists('facets', $searchResult[$search->BODY])) {
	        $location_state_array = ($searchResult[$search->BODY]['facets']['BoatStateCode']);
	        if(isset($location_state_array[''])) {
	            unset($location_state_array['']);
	        }
	    }
	    
	    if (array_key_exists('facets', $searchResult[$search->BODY])) {
	        $location_city_array = ($searchResult[$search->BODY]['facets']['BoatCityName']);
	        if(isset($location_city_array[''])) {
	            unset($location_city_array['']);
	        }	        
	    }	
	    
	    $canonical = Inventory_Helper::generate_search_url(array('per_page' => 5000, 'page' => 1, 'option' => 'view-all', 'sort' => ''), true);
	    $prev_link = Inventory_Helper::generate_previous_search_url();
	    $next_link = Inventory_Helper::generate_next_search_url($all_result);	    
	    
	    $post->inventory = array(
	        'search'      => $search,
	        'countries'   => $countries,
	        'states'      => $states,
	        'currencies'  => $currencies,
	        'currency'    => $currency,
	        'feet2metres' => $feet2metres,
	        'results_per_page' => $results_per_page,
	        'criteria'    => $criteria,
	        'fields'      => $fields,
	        'facetFields' => $facetFields,
	        'sort'        => $sort,
	        'debug'       => $debug,
	        'params'      => $params,
	        'results'     => $results,
	        'searchResult'           => $searchResult,
	        'manufacturer_array'     => $manufacturer_array,
	        'model_array'            => $model_array,
	        'condition_array'        => $condition_array,
	        'category_array'         => $category_array,
	        'location_country_array' => $location_country_array,
	        'location_state_array'   => $location_state_array,
	        'location_city_array'    => $location_city_array,
	        'all_result'             => $all_result,
	        'canonical_link'         => $canonical,
	        'rel_next_link'          => $next_link,
	        'rel_prev_link'          => $prev_link
	    );

	    // remove wpseo canonicsal and add a custom one
	    add_filter( 'wpseo_canonical', array($this, 'inventory_remove_meta_canonical'), 10, 1);
	    add_action( 'wp_head', array($this, 'inventory_search_add_canonical'), 1, 1 );
	    
	}
	
	/**
	 * Load boat details and append output as array
	 * to post object ($post->inventory)
	 *
	 * @param object $post
	 */
	public function load_boat_details_in_post(&$post)
	{
	    global $wp_query;
	     
        self::load_dependencies();
	     
	    $search = new Search();
	    $countries = new Countries();
	    $states = new States();
	    $currencies = new Currencies();
	     
	    $feet2metres = 0.3048;
	    $lbs2tonnes = 0.00045359237;  //Metric
	    $lbs2tons = 0.0004464286;     // Imperial (UK Long Ton)
	    $kgs2tonnes = 0.001;  //Metric
	     
	    $url = Dmm_Url_Helper::get_current_page_url();
	     
	    //Get data from SOLR
	    $boatid = $wp_query->query['BoatID'];
	    $uom = Inventory_Helper::get_units_of_measure();
	    $currency =  !empty($_GET['currency']) ? $_GET['currency'] : Inventory_Helper::get_default_currency_symbol();
	    $criteria = !empty($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] . '&' : '';
	    $criteria .= "DocumentID=$boatid&currency=$currency";
	     
	    if($uom == 'Imperial-UK') {
	        $criteria .= '&locale=de';
	    }
	    elseif($uom == 'Metric') {
	        $criteria .= '&locale=nl';
	    }
	     
	    $fields = NULL;
	    $facetFields = NULL;
	    $results_per_page=1;
	    $sort='';
	    $debug=false;
	    $searchResult = $search->search($criteria, $fields, $facetFields, $results_per_page, $sort, $debug);
	    $error = '';
	    $url = Dmm_Url_Helper::get_current_page_url();
	     
	    if (!array_key_exists($search->STATUS,$searchResult)) {
	        $error .= "<!-- An unknown error occurred -->";
	        $error .= "<div id=\"page-numbers\">An error was encountered</div>";
	    } else if ($searchResult[$search->STATUS] == $search->ERROR) {
	        $error .= 'An error was encountered>br />';
	        $error .= print_r($searchResult[$search->BODY], 1);
	    } else {
	        $boat = $searchResult[$search->BODY]['results'][0];
	    }
	     
	    $post->inventory = array(
	        'boat'        => $boat,
	        'boatid'      => $boatid,
	        'search'      => $search,
	        'countries'   => $countries,
	        'states'      => $states,
	        'currencies'  => $currencies,
	        'currency'    => $currency,
	        'feet2metres' => $feet2metres,
	        'lbs2tonnes'  => $lbs2tonnes,
	        'lbs2tons'    => $lbs2tons,
	        'kgs2tonnes'  => $kgs2tonnes,
	        'criteria'    => $criteria,
	        'fields'      => $fields,
	        'facetFields' => $facetFields,
	        'sort'        => $sort,
	        'debug'       => $debug,
	        'error'       => $error,
	        'url'         => $url,
	        'results_per_page' => $results_per_page,
	        'searchResult' => $searchResult,
	    );
	     
	    // override wordpress-seo meta description
	    add_filter( 'wpseo_metadesc', array($this,'inventory_details_add_meta_description'), 10, 1 );
	    add_filter( 'wpseo_canonical', array($this, 'inventory_remove_meta_canonical'), 10, 1);
	    add_action( 'wp_head', array($this, 'inventory_details_add_meta_ogimage'), 1, 1 );
	     
	    $post->post_title = $post->inventory['boat']['ModelYear'] . ' ' .
	        $post->inventory['boat']['MakeString'] . ' ' .
	        $post->inventory['boat']['Model'];
	
	     
	}
	
	/**
	 * Add first image as og:image meta tag
	 */
	public function inventory_details_add_meta_ogimage()
	{
	    global $post;
	
	    if(isset($post->inventory['boat']['Images'][0]['Uri'])) {
	        echo '<meta name="og:image" content="' . $post->inventory['boat']['Images'][0]['Uri'] . '" />' . "\n";
	    }
	}
	
	/**
	 * Add canonical and next/prev links if applicable
	 */
	public function inventory_search_add_canonical()
	{
	    global $post;
	    
	    if(!empty($post->inventory['canonical_link'])) {
	        echo '<link rel="canonical" href="' . $post->inventory['canonical_link'] . '" />' . "\n";
	    }
	    
	    if(!empty($post->inventory['rel_next_link'])) {
	        echo '<link rel="next" href="' . $post->inventory['rel_next_link'] . '" />' . "\n";
	    }	    
	    
	    if(!empty($post->inventory['rel_prev_link'])) {
	        echo '<link rel="prev" href="' . $post->inventory['rel_prev_link'] . '" />' . "\n";
	    }	    
	}	
	
	/**
	 * Canonical link can be an issue for virtual pages.
	 * @param string $str
	 */
	public function inventory_remove_meta_canonical($str) {
	    return '';
	}
	
	/**
	 * Add custom meta description
	 *
	 * @param string $str
	 * @return string
	 */
	public function inventory_details_add_meta_description($str) {
	    global $post;
	
        if(!empty($post->inventory['boat']['GeneralBoatDescription']) && is_array($post->inventory['boat']['GeneralBoatDescription'])) {
            $str = htmlentities(strip_tags(current($post->inventory['boat']['GeneralBoatDescription'])));
        }
	
	    return $str;
	}	
	
	/**
	 * Initialize and load dependencies
	 */
	private static function load_dependencies() {
	    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/inventory-helper.class.php';
	    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/search.class.php';
	    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/countries.class.php';
	    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/states.class.php';
	    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/currencies.class.php';
	}	
	
	/**
	 * Get price query for search API
	 *
	 * @return string
	 */
	private static function get_price_query()
	{
	    $price = '';
	    if( (isset($_REQUEST['min-price']) && !empty($_REQUEST['min-price'])) && (isset($_REQUEST['max-price']) && !empty($_REQUEST['max-price'])) ) {
	        $price = $_REQUEST['min-price'] . ':' . $_REQUEST['max-price'] . '|' . self::get_currency();
        }
        elseif(isset($_REQUEST['min-price']) && !empty($_REQUEST['min-price'])) {
            $price = $_REQUEST['min-price'] . ':99999999|' . self::get_currency();
        }
        elseif(isset($_REQUEST['max-price']) && !empty($_REQUEST['max-price'])) {
            $price = '1:' . $_REQUEST['max-price'] . '|' . self::get_currency();
        }

        return $price;
	}
	
	/**
	 * Get length query for search API
	 *
	 * @return string
	 */
	private static function get_length_query()
	{
	    $length = '';
	
	    if( (isset($_REQUEST['min-length']) && !empty($_REQUEST['min-length'])) && (isset($_REQUEST['max-length']) && !empty($_REQUEST['max-length'])) ) {
            $length = $_REQUEST['min-length'] . ':' . $_REQUEST['max-length'] . '|' . self::get_length();
        }
        elseif(isset($_REQUEST['min-length']) && !empty($_REQUEST['min-length'])) {
            $length = $_REQUEST['min-length'] . ':5000|' . self::get_length();
        }
        elseif(isset($_REQUEST['max-length']) && !empty($_REQUEST['max-length'])) {
            $length = '1:' . $_REQUEST['max-length'] . '|' . self::get_length();
        }

        return $length;
	}
	
	/**
	 * Get requested currency or default one
	 * if not specified
	 */
	private static function get_currency() {
	    $currency = isset($_REQUEST['currency']) && !empty($_REQUEST['currency']) ?
	    $_REQUEST['currency'] :
	    Inventory_Helper::get_default_currency_symbol();
	
	    return $currency;
	}
	
	/**
	 * Get requested length or default one
	 * if not specified
	 *
	 * @return string
	 */
	private static function get_length()
	{
	    $length = isset($_REQUEST['unit']) && !empty($_REQUEST['unit']) ?
	    $_REQUEST['unit'] :
	    Inventory_Helper::get_default_length_unit();
	
	    return $length;
	}	
}