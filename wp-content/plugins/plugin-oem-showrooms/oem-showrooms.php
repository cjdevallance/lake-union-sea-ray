<?php
/*
Plugin Name: New Boat Showrooms
Plugin URI: https://github.dominionenterprises.com/DMM-CW-US/plugin-new-boat-showrooms
Description: This plugin handles provisioning brand imports and presentation for New Boat Showrooms. Requires classes and options in DMM Core plugin. See Github README.md for more info.
Version: 1.0
Author: Tim Hysniu <tim.hysniu@dominionmarinemedia.com>
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! defined('OEM_SHOWROOMS_PREFIX')) {
    define('OEM_SHOWROOMS_PREFIX', 'oem_showrooms_');
}

if( ! defined('OEM_SHOWROOMS_BASE_URL')) {
    define('OEM_SHOWROOMS_BASE_URL', plugin_dir_url( __FILE__ ) );
}

spl_autoload_register(function ($class) {
    
    if(!strstr(__DIR__, 'plugin-oem-showrooms')) {
        return;
    }
    
    $class = strtolower($class);
    $class = str_replace('_', '-', $class);
    $file = __DIR__ . '/includes/lib/class-' . $class . '.php';
    
    if(file_exists($file)) {
        include $file;
    }
});

require_once( 'includes/class-oem-showrooms.php' );
require_once( 'includes/class-oem-showrooms-settings.php' );

function Oem_Showrooms () {
    $instance = Oem_Showrooms::instance( __FILE__, '1.0.0' );
    if ( is_null( $instance->settings ) ) {
        $instance->settings = Oem_Showrooms_Settings::instance( $instance );
    }
    return $instance;
}

Oem_Showrooms();