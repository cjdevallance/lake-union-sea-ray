<?php
/*
Plugin Name: DMM Core
Plugin URI: https://github.dominionenterprises.com/DMM-CW/plugin-core
Description: This is a core plugin containing a set of shared libraries
Version: 1.0
Author: DMM <tim.hysniu@dominionmarinemedia.com>
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! defined('CORE_PREFIX')) {
    define('CORE_PREFIX', 'core_');
}

if( ! defined('CORE_PLUGIN_PATH')) {
    define('CORE_PLUGIN_PATH', __DIR__);
}

// register autoloaders
spl_autoload_register(function ($class) {

    if(!strstr(__DIR__, 'plugin-core')) {
        return;
    }

    $class = strtolower($class);
    $class = str_replace('_', '-', $class);
    $file = __DIR__ . '/includes/lib/class-' . $class . '.php';

    if(file_exists($file)) {
        include $file;
    }
});



require_once('vendor/autoload.php');
require_once( 'includes/class-dmm-core.php' );
require_once( 'includes/class-dmm-core-settings.php' );



function Dmm_Core() {
    $instance = Dmm_Core::instance( __FILE__, '1.0.0' );
    if ( is_null( $instance->settings ) ) {
        $instance->settings = Dmm_Core_Settings::instance( $instance );
    }
    return $instance;
}

Dmm_Core();
