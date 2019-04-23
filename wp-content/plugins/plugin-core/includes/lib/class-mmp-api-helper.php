<?php
/**
* Mmp_Api_Helper
*
* @package plugin-core
*
* @version 1.0
* @author Tim Hysniu
* @link https://github.dominionenterprises.com/DMM-CW-US/plugin-core
*/

class Mmp_Api_Helper {
    
    public static $mmp_api = null;
    
    /**
     * Get boat details
     * 
     * @param number $document_id
     * @return array
     */
    public static function get_boat_details($document_id, $currency = '', $params = array())
    {
        $api = self::get_mmp_api();
        
        $api->set_document_id($document_id);
        $api->add_field('Owner');
        $api->set_fields(null);
        $api->set_models(false);
        
        if(!empty($currency)) {
            $api->set_currency($currency);
        }
        
        if(!empty($params)) {
            foreach($params as $key => $value) {
                $api->add_filter($key, $value);
            }
        }
        
        $results = $api->get_results();
        
        $boat_details = !empty($results['results']) && is_array($results['results']) ? 
            current($results['results']) : 
            array();
         
        return $boat_details;        
    }
    
    private static function get_mmp_api()
    {
        if(is_null(self::$mmp_api)) {
            $mmp_api_key = get_option('mmp_api_key');
            self::$mmp_api = new Mmp_API($mmp_api_key);
        }
    
        return self::$mmp_api;
    }    
}