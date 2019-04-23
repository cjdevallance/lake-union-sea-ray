<?php
class Dmm_Url_Helper {
    public static function get_current_page_url(){
        $page_url = 'http';
        if (in_array("HTTPS", $_SERVER) && $_SERVER["HTTPS"] == "on") {
            $page_url .= "s";
        }
        
        $page_url .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        
        return $page_url;        
    }
    
    public static function get_pages_by_template($template_file, $return_first = false)
    {
        $query = 'post_type=page&meta_key=_wp_page_template&meta_value=' . $template_file;
        $pages = query_posts($query);
        
        if($return_first && !empty($pages)) {
            return current($pages);
        }
        
        return $pages;
    }
}