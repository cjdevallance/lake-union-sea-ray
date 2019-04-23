<?php
/**
 * Import_Supported_Brands - Import supported brands from IMT
 *
 * @package oem-showrooms
 *
 * @version 0.9
 * @author Tim Hysniu
 * @link https://github.dominionenterprises.com/DMM-CW-US/plugin-oem-showrooms
 */

/**
 * Import_Supported_Brands class
 *
 */
class Import_Supported_Brands {
    
    protected $_imt_party_id = '';
    protected $_imt_service_url = '';
    
    // brands as they are pulled from provisioning
    protected $_provisioning_brands = array();
    
    // maps a brand to OEM party ID
    protected $_brand_party_map = array();
    
    // brands mapped to their rrespective OEM party IDs 
    protected $_brand_ids = array();
    
    // statistics about last import(s)
    protected $_stats = array('http_success' => 0);
    
    private $_party_xml = NULL;
    private $_brands_xml = NULL;
    
	function __construct($provisioning_ws_url = '', $imt_party_id = 0) {
        $this->_imt_party_id = intval($imt_party_id);
        $this->_imt_service_url = trim($provisioning_ws_url, '/ \t\n\r');
	}
	
	/**
	 * @param string $content
	 */
	public function set_party_xml($content)
	{
	    $this->_party_xml = $content;
	}
	
	/**
	 * @param string $content
	 */
	public function set_brands_xml($content) 
	{
	    $this->_brands_xml = $content;
	}
	
	/**
	 * @return arra
	 */
	public function get_stats()
	{
	    return $this->_stats;
	}
	
	/**
	 * Returns only party IDs from already fetched supported brands
	 * 
	 * @return array
	 */
	public function get_supported_brands_party_ids()
	{
	    $party_ids = array();
	    if(!empty($this->_brand_party_map)) {
	       foreach($this->_brand_party_map as $brand_id => $party) {
	           array_push($party_ids, $party['id']);
	       } 
	    }
	    
	    return $party_ids;
	}
	
	/**
	 * Gets supported brands including party id and logo
	 * Requires two privisioning calls
	 * 
	 * @return array
	 */
	public function get_supported_brand_parties()
	{
	    // pull supported brands; we only need to save supported brands
        $this->get_supported_brands();
        $supported_brand_ids = array_keys($this->_provisioning_brands);
	    
	    if(!empty($this->_brand_party_map)) {
	        return $this->_brand_party_map;
	    }
	     
	    $brandsServiceUrl = $this->_imt_service_url . '/brands?updatedSince=2010-09-03T11:05:00.000-0800';
	    if(empty($this->_brands_xml)) {
	        $this->_brands_xml = $this->_curl_xml($brandsServiceUrl);
	    }
	     
	    if(empty($this->_brands_xml)) {
	        error_log("no brands service was loaded: " . $brandsServiceUrl);
	        return;
	    }
	    
	    $xml = new SimpleXMLElement($this->_brands_xml);
	    $result = $xml->xpath('/party-list/parties');
	    
	    $this->_brand_party_map = array();
	    while(list( , $node) = each($result)) {
	        $attributes = $node->attributes();
	        $brand_id = (string) $attributes['id'];
	        
	        $oem_party_id = (string) $attributes['parent-id'];
	        $oem_name = (string) $node->name;
	        $oem_logo_url = trim($node->{'logo-url'});
	        
	        $oem = array(
	                'id' => $oem_party_id,
	                'name' => $oem_name,
	                'logo' => $oem_logo_url
	        );
	        
	        if(is_numeric($oem_party_id) && is_numeric($brand_id) && in_array($brand_id, $supported_brand_ids)) {
	            $this->_brand_party_map[$brand_id] = $oem;
	        }
	    }
	    
	    $this->_stats['total_brands'] = count($result);
	    $this->_stats['brands_supported'] = count($this->_brand_party_map);
	    $this->_stats['http_success'] = 1;
	    
	    return $this->_brand_party_map;
	    
	}
	
	/**
	 * Get supported brand id's from provisioning
	 * 
	 * @return array
	 */
	public function get_supported_brands()
	{
	    if(!empty($this->_provisioning_brands)) {
	        return $this->_provisioning_brands;
	    }
	    
	    $partyServiceUrl = $this->_imt_service_url . '/parties/' . $this->_imt_party_id;
	    if(empty($this->_party_xml)) {
	        $this->_party_xml = $this->_curl_xml($partyServiceUrl);
	    }
	    
	    if(empty($this->_party_xml)) {
	        error_log("no party service was loaded: " . $partyServiceUrl);
	        return;
	    }
	    
	    $xml = new SimpleXMLElement($this->_party_xml);
	    $result = $xml->xpath('/org-unit/supplier-relationships/party-relationship');
	    
	    $supported_brands = array();
	    
	    while(list( , $node) = each($result)) {
	        $attributes = $node->attributes();
	        
            $client_party_string = (string) $attributes['client-party'];
            $supplier_party_string = (string) $attributes['supplier-party'];
            
	        // we only want supported brands of main user
	        $supplier_party_vars = explode(':', $supplier_party_string);
	        $client_party_vars = explode(':', $client_party_string);
	        
	        if(!empty($supplier_party_vars[1]) && !empty($client_party_vars[1])) {
	            
	            if($supplier_party_vars[1] != $this->_imt_party_id) {
	                continue;
	            }
	            
	            if(is_numeric($client_party_vars[1]) && $client_party_vars[0] == 'brand') {
	                $supported_brands[$client_party_vars[1]] = $client_party_vars[2];
	            }
	        }
	    }
	    
	    $this->_provisioning_brands = $supported_brands;
	    
	    return $this->_provisioning_brands;
	    
	}
	
	/**
	 * Curl and return contents
	 */
	protected function _curl_xml($url)
	{  
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_FAILONERROR,1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	    curl_setopt($ch, CURLOPT_VERBOSE, true);
	    $retValue = curl_exec($ch);
	    curl_close($ch);
	    
	    return $retValue;
	}

}