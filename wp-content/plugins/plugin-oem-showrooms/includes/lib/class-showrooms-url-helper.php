<?php
/**
 * Showrooms_URL_Helper
 *
 * @package oem-showrooms
 *
 * @version 0.9
 * @author Tim Hysniu
 * @link https://github.dominionenterprises.com/DMM-CW-US/plugin-oem-showrooms
 */

/**
 * Showrooms_URL_Helper class
 *
 */
class Showrooms_URL_Helper {

    private static $_oem_showrooms_detail_url = '';
    private static $_landing_page_slug = '';
    
    public static function get_models_url($brand_id)
    {
        $permalink = NULL;
        $page_id = get_option(OEM_SHOWROOMS_PREFIX . 'brand_page_id_' . $brand_id);
        if(!empty($page_id)) {
            $permalink = get_permalink( $page_id );
        }
        
        return $permalink;
    }
    
    public static function get_oem_showrooms_detail_url() {
        if(empty(self::$_oem_showrooms_detail_url)) {
            self::$_oem_showrooms_detail_url = get_option('oem_showrooms_detail_url');
        }
        
        return self::$_oem_showrooms_detail_url;
    }
    
    public static function get_landing_page_slug() {
        if(empty(self::$_landing_page_slug)) {
            self::$_landing_page_slug = Oem_Showrooms_Settings::get_landing_page_slug();
        }
        
        return self::$_landing_page_slug;
    }
    
    public static function get_model_details_url($params = array()) 
    {
        $url = self::get_landing_page_slug() . '/' . self::get_oem_showrooms_detail_url();
        $url = trim($url, '/ ');
        
        if(!empty($params)) {
            foreach($params as $paramKey => $paramVal) {
                $paramVal = self::slugify($paramVal);
                $url = str_replace('[' . $paramKey . ']', $paramVal, $url);
            }
        }
        
        return '/' . $url;
    }
    
    
    public static function slugify($text)
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
    
}