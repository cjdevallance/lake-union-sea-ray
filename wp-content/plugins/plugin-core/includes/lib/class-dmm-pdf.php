<?php
/**
 * Dmm_Pdf - Html to PDF conversion
 *
 * @package plugin-core
 *
 * @version 1.0
 * @author Tim Hysniu
 * @link https://github.dominionenterprises.com/DMM-CW-US/plugin-core
 */

/**
 * Dmm_Pdf class
 *
 */
class Dmm_Pdf {
    
    private $_DOMPDF_instance = null;
    
    public function __construct( ) 
    {
        if(!defined('DOMPDF_ENABLE_AUTOLOAD')) {
            define('DOMPDF_ENABLE_AUTOLOAD', false);
        }
        
        if(!defined('DOMPDF_ENABLE_REMOTE')) {
            define('DOMPDF_ENABLE_REMOTE', true);
        }    
        
        require_once CORE_PLUGIN_PATH . '/vendor/dompdf/dompdf/dompdf_config.inc.php';  
        
        $this->_DOMPDF_instance = new DOMPDF();
        
    }
    
    public function get_pdf($html, $title = 'document.pdf') {
        $this->_DOMPDF_instance->load_html($html);
        $this->_DOMPDF_instance->render();
        $this->_DOMPDF_instance->stream( $title );
        exit();
    }
    
}