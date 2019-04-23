<?php
/**
 * Mmp_API - Interface used to pull content from MMP API
 * Web service documentation: http://api.boats.com/docs/overview
 *
 * @package plugin-core
 *
 * @version 1.0
 * @author Tim Hysniu
 * @link https://github.dominionenterprises.com/DMM-CW-US/plugin-core
 */

/**
 * Mmp_API class
 *
 */
class Mmp_API implements Dmm_Service {
    
    // MMP Key for custome
    protected $_mmp_api_key = '';
    
    // MMP Service Endpoint
    protected $_services_url = 'https://services.boats.com/%s/mmp/search';
    
    // Party ID of the customer
    protected $_imt_party_id = '';
    
    // This is the Boat Listing ID
    protected $_document_id = '';
    
    // Currency
    protected $_currency = '';
    
    // Additional gilters
    protected $_filters = array();
    
    // Facet fields
    protected $_facets = '';
        
    // Fields to be pulled in
    protected $_fields = 'DocumentID,SalesStatus,Images,NumberOfEngines,MakeString,ModelYear,Model,DesignerName,GeneralBoatDescription,BoatClassCode,AdditionalDetailDescription,Engines,WaterTankCountNumeric,WaterTankCapacityMeasure,FuelTankCapacityMeasure,TotalEnginePowerQuantity,BoatHullMaterialCode,NominalLength,LengthOverall';
    
    // Only pull models
    protected $_models = true;
    
    // Only pull current models
    protected $_current_models = true;
    
    // Sort order
    protected $_sort = 'Model|asc';
    
    // Current page
    protected $_page = 1;
    
    // Results per page
    protected $_per_page = 20;
    
    // Number of records in last query
    protected $_num_rows = 0;  
    
	function __construct($mmp_api_key = NULL) 
	{
        $this->_mmp_api_key = $mmp_api_key;
	}
	
	/**
	 * Add a field to results
	 * 
	 * @param string $field
	 */
	public function add_field($field) {
	    $this->_fields .= (empty($this->_fields) ? $field : ',' . $field);
	}
	
	/**
	 * Set party ID for which we are pulling listings
	 * 
	 * @param number $imt_party_id
	 */
	public function set_party_id($imt_party_id = 0) {
	    $this->_imt_party_id = $imt_party_id;
	}
	
	/**
	 * Add a filter to the API query
	 * 
	 * @param string $field
	 * @param string $value
	 */
	public function add_filter($field, $value)
	{
	    $this->_filters[$field] = $value;
	}
	
	/**
	 * Set comma separated facet fields
	 * 
	 * @param string $facets
	 */
	public function set_facets($facets) {
	    $this->_facets = $facets;
	}
	
	/**
	 * Set boat listing ID for use as filter
	 * 
	 * @param number $document_id
	 */
	public function set_document_id($document_id = 0)
	{
	    $this->_document_id = $document_id;
	}
	
	/**
	 * Set currency. See list of supported currencies at:
	 * http://api.boats.com/docs/services/details?s=inventory
	 * 
	 * @param string $currency
	 */
	public function set_currency($currency) {
	    $this->_currency = $currency;
	}
	
	/**
	 * We either want to query by party ID  or document ID
	 * 
	 * @return boolean
	 */
	public function can_query()
	{
	    return !empty($this->_mmp_api_key) && 
	       (!empty($this->_imt_party_id) || !empty($this->_document_id));
	}
	
	/**
	 * Returns an array of elements pulled from MMP API
	 * 
	 * @return array
	 */
	public function get_results()
	{
	    if( !$this->can_query() ) {
	        return array();
	    }
	     
	    // reset num results
	    $this->_num_rows = 0;
	     
	    // get fetch url
	    $url = $this->build_query_url();
	     
	    // pull from API
	    $json = $this->_curl_xml($url);
	    $data = json_decode($json, 1);
        
        if(!empty($data['numResults'])) {
            $this->_num_rows = intval($data['numResults']);
        }
        
	    if(!empty($data['facets'])) {
            $data['facets'] = $this->_filter_empty_facets($data['facets']);
        }       
        
        return $data;        
	}
	
	/**
	 * Filter out empty facet results
	 * 
	 * @return array $facets
	 */
	private function _filter_empty_facets($facet_results)
	{
	    $facets = array();
	    if(!empty($facet_results)) {
            foreach($facet_results as $field => &$facet)
            {
                $non_empties = array();
                foreach($facet as $value => $count) {
                    if(intval($count) > 0) {
                        $non_empties[$value] = $count;
                    }
                }
                
                $facet = $non_empties;
            }
	    }	
	    
	    return $facet_results;
	}
	
	/**
	 * @return number
	 */
	public function get_num_results_last_query()
	{
	    return $this->_num_rows;
	}
	
	/**
	 * Sets the supported list of party ID's for supported brands.
	 * These ID's will be used as prerequesite for the import.
	 * 
	 * @param array $array_parties
	 */
	public function set_supported_brand_parties($array_parties)
	{
	    if(!empty($array_parties) && is_array($array_parties)) {
	        $this->_supported_brand_parties();
	    }
	    else {
	        error_log('Import_Showrooms: invalid or empty array of supported brands' );
	    }
	}
	
	/**
	 * @param string $services_url
	 */
	public function set_services_url($services_url)
	{
	    $this->_services_url = $services_url;
	}
	
	/**
	 * Set fields we want in resultset
	 * 
	 * @param strig $fields
	 */
	public function set_fields($fields)
	{
	    $this->_fields = $fields;
	}
	
	
	/**
	 * Set to pull only models
	 *
	 * @param string $_models
	 */
	public function set_models($models = true)
	{
	    $this->_models = $models;
	    if(!$models) {
	        $this->set_current_models(NULL);
	    }
	}
	
	/**
	 * Set to pull only current models. Only works
	 * if $_models is set to true
	 * 
	 * @param string $_current_models
	 */
	public function set_current_models($current_models = true) 
	{
	    $this->_current_models = $current_models;
	}
	
	/**
	 * Set sort field
	 * 
	 * @param string $field
	 * @param string $sort_order
	 * @return string
	 */
	public function set_sort_by($field, $sort_order = 'asc') 
	{
	    if(empty($field)) {
	        $this->_sort = null;
	    }
	    else {
    	    $sort_order = ($sort_order == 'asc') ? 'asc' : 'desc';
    	    $this->_sort = $field . '|' . $sort_order;
	    }
	    
	    return $this->_sort;
	}
	
	/**
	 * @param number $page
	 */
	public function set_current_page($page = 1)
	{
	    $this->_page = $page;
	}
	
	/**
	 * @param number $num_results
	 */
	public function set_results_per_page($num_results = 20)
	{
	    $this->_per_page = $num_results;
	}
	
	/**
	 * Generate URL to MMP API
	 * 
	 * @return string
	 */
	public function build_query_url()
	{
	    $url = sprintf($this->_services_url, $this->_mmp_api_key);
	    $url .= '?';
	    
	    if(!empty($this->_models)) {
	        $url .= '&models=true';
	    }	    
	    
	    if(isset($this->_models) && isset($this->_current_models)) {
	        $url .= '&currentModels=' . (!empty($this->_current_models) ? 'true' : 'false');
	    }	    
	    
	    if(!empty($this->_imt_party_id)) {
	       $url .= '&OwnerPartyId=' . $this->_imt_party_id;
	    }
	    
	    if(!empty($this->_document_id)) {
	        $url .= '&DocumentID=' . $this->_document_id;
	    }	   
	    
	    if(!empty($this->_filters) && is_array($this->_filters)) {
	        foreach($this->_filters as $filter_key => $filter_value) {
	            $url .= '&' . $filter_key . '=' . urlencode($filter_value);
	        }
	    }
	    
	    if(!empty($this->_fields)) {
	       $url .= '&fields=' . $this->_fields;
	    }
	    
	    if(!empty($this->_sort)) {
	       $url .= '&sort=' . $this->_sort;
	    }
	    
	    if(!empty($this->_per_page)) {
	        $url .= '&rows=' . $this->_per_page;
	    }
	    
	    if(!empty($this->_page)) {
	        $current_page = intval($this->_page);
	        $per_page = intval($this->_per_page);
	        if($current_page > 0 && $per_page > 0) {
	           $offset = ($current_page - 1) * $per_page;
	           $url .= '&offset=' . $offset;
	        }
	    }
	    
	    if(!empty($this->_facets)) {
	        $url .= '&facets=' . $this->_facets;
	    }
	    
	    if(!empty($this->_currency)) {
	        $url .= '&currency=' . $this->_currency;
	    }
	    
	    return $url;
	}
	/**
	 * Ajax service handler. Supported params: fields, facets, party_id
	 * 
	 * @param array $config
	 */
	
	public static function do_request($config = array())
	{
	    $api = new Mmp_API($config['key']);
	    
	    if(!empty($_REQUEST['fields'])) {
	        $api->set_fields($_REQUEST['fields']);
	    }
	    
	    if(!empty($_REQUEST['facets'])) {
	        $api->set_facets($_REQUEST['facets']);
	    }	
	    
	    if(!empty($_REQUEST['rows'])) {
	        $api->set_results_per_page($_REQUEST['rows']);
	    }	 
	    
	    if(!empty($_REQUEST['party_id'])) {
	        $api->set_party_id($_REQUEST['party_id']);
	    }	    
	    
	    if(!empty($_REQUEST['filters']) && is_array($_REQUEST['filters'])) {
	        foreach($_REQUEST['filters'] as $field => $value) {
	            $api->add_filter($field, $value);
	        }
	    }	 
	    
	    $results = $api->get_results();
	    
	    return $results;
	    
	}
	
    /**
     * Curl and return contents
     * 
     * @param string $url
     * @return string
     */
	protected function _curl_xml($url)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_FAILONERROR,1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	    curl_setopt($ch, CURLOPT_VERBOSE, true);
	    $retValue = curl_exec($ch);
	    curl_close($ch);
	     
	    return $retValue;
	}	

}