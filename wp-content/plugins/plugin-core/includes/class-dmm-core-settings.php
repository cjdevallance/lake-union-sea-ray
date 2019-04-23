<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Dmm_Core_Settings {
    
    private static $_instance = null;
       
    public $parent = null;
    
    public function __construct( $parent ) {
        $this->parent = $parent;
        
        add_action( 'admin_menu', array($this, 'core_menu' ));
        add_filter( 'plugin_action_links', array($this, 'core_add_settings'), 10, 5 );
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
    
    public function core_menu()
    {
        $hook = add_options_page(
                __('Core Settings', 'plugin-core'),
                __('Core Settings', 'plugin-core'),
                'manage_options',
                'plugin-core',
                array($this, 'core_options' ) );
    
        add_action( 'admin_init', array($this, 'register_core_settings' ));
        //add_action( 'load-'.$hook, array($this, 'showrooms_post_save_options' ));
    }    
    
    public function register_core_settings() {
    
        $settings = array(
                'imt_party_id',
                'mmp_api_key',
                'provisioning_ws_url'
        );
    
        foreach($settings as $option) {
            register_setting( 'core-settings-group', $option );
        }
    }    
    
    /**
     * Add Settings
     *
     * @param array $actions
     * @param string $plugin_file
     * @return array
     */
    public function core_add_settings( $actions, $plugin_file )
    {
        if (strstr($plugin_file, 'plugin-core')) {
    
            $settings = array(
                    'settings' => '<a href="options-general.php?page=plugin-core">' . __('Settings', 'General') . '</a>'
            );
            $actions = array_merge($settings, $actions);
        }
    
        return $actions;
    }   

    public function core_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        include(dirname(__FILE__) . '/../settings.php');
         
    }    
        

}