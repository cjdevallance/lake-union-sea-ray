<?php
/*
 *
 * Plugin Name: Inventory Plugin
 * Plugin URI:
 * Description: DMM Inventory WordPress plugin
 * Version: 1.0.0
 * Author: Joe Fairman
 * Author URI: http://www.dominionmarinemedia.com
 *
 * Text Domain: inventory-plugin
 * Domain Path: /languages/
 *
 * @package WordPress
 * @author Joe Fairman
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if(!defined('INVENTORY_PREFIX')) {
    define('INVENTORY_PREFIX', 'inventory_');
}

if( ! defined('INVENTORY_BASE_DIR')) {
    define('INVENTORY_BASE_DIR', plugin_dir_url( __FILE__ ) );
}

// Load plugin class files
require_once('includes/class-inventory-plugin.php');
require_once( 'includes/class-inventory-plugin-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/api.class.php' );
require_once( 'includes/lib/post-type.class.php' );
require_once( 'includes/lib/taxonomy.class.php' );
require_once( 'includes/lib/inventory-helper.class.php' );
require_once( 'includes/lib/widget.class.php' );

function Inventory_Plugin () {
	$instance = Inventory_Plugin::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Inventory_Plugin_Settings::instance( $instance );
	}

	return $instance;
}

Inventory_Plugin();