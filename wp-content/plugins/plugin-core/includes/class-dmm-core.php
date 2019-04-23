<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Dmm_Core {
    
    private static $_instance = null;
       
    public $settings = null;
    public $file;
    public $dir;
    
    const SERVICE_CONTACT_US = 'contact';
    const SERVICE_MMP_RESULTS = 'mmp_search';
    
    public function __construct(  $file = '', $version = '1.0.0' ) {
        
        $this->file = $file;
        $this->dir = dirname( $this->file );
        
        add_action( 'init', array( $this, 'core_init' ), 0 );
        
        register_activation_hook( $this->file, array( $this, 'core_activation' ) );
        register_deactivation_hook( $this->file, 'core_deactivation' );       
        
        add_filter('query_vars', array($this, 'core_add_query_vars') );

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
     * Init with lang support
     */
    public function core_init() {
        
        // handle all requests!
        $this->handle_service_requests();
    }
    
    /**
     * Plugin activation
     */
    public function core_activation() {
        
    }
    
    /**
     * Plugin deactivation
     */
    public function core_deactivation() {
        
    }    
    
    public function core_add_query_vars($vars) {
        $vars[] = "format";
    
        return $vars;
    }    
    
    /**
     * @todo Move this to an API controller class with URL: /api/*
     * 
     * Service requests controller
     */
    private function handle_service_requests() {
        if(!empty($_REQUEST['service'])) {
            switch($_REQUEST['service']) {
                case self::SERVICE_CONTACT_US:
                    $response = Mailer::do_request();
                    break;
                case self::SERVICE_MMP_RESULTS:
                    $response = Mmp_API::do_request(array('key' => get_option('mmp_api_key')));
                    break;                    
                default:
            }
            
            print(json_encode($response));
            exit();
        }
    } 
    

    /**
     * Get Current URL 
     * 
     * @param bool $query_string
     */
    public function get_current_url($query_string = false)
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? 'https://' : 'http://';
        $request_uri = current(explode("?", $_SERVER['REQUEST_URI']));
        $url = $protocol . $_SERVER['HTTP_HOST'] . $request_uri;

        if($query_string) {
            $url .= '?' . $_SERVER['QUERY_STRING'];
        }

        return $url;
    }
    
        
}