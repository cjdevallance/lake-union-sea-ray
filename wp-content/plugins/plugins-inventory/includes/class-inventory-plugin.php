<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Inventory_Plugin {


	private static $_instance = null;
	public $settings = null;
	public $_version;
	public $_token;
	public $file;
	public $dir;
	public $scripts_dir;
	public $scripts_url;
	public $script_suffix;
    public $core_dir;

	public function __construct ( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token = 'inventory_plugin';

		// Load plugin environment variables
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->scripts_dir = trailingslashit( $this->dir ) . 'assets';
		$this->scripts_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );
        $this->core_dir = trailingslashit( $this->dir ) . 'core';

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        // Plugin Installation
		register_activation_hook( $this->file, array( $this, 'install' ) );

        // DB Table Installation
        register_activation_hook( $this->file, array( $this, 'table_install' ) );

		// Boat Details Page Installation
		register_activation_hook( $this->file, array( $this, 'details_page_install' ) );

		// Load frontend JS & CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'inventory_enqueue_scripts' ), 30 );

		// Load admin JS & CSS
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );

		// Handle localisation
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );

		// Load API for generic admin functions
		if ( is_admin() ) {
			$this->admin = new Inventory_Plugin_Admin_API();
		}

        // Add main page to menu
        add_action( 'admin_menu' , array( $this, 'add_menu_admin' ) );

		// Add settings link to plugins page
		//add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_admin_link' ) );
		
		add_filter('rewrite_rules_array', array($this, 'inventory_add_rewrite_rules') );

		add_filter('query_vars', array($this, 'inventory_query_vars' ) );

        add_filter('get_header', array($this, 'inventory_get_header'));
        
        add_action('template_redirect', array($this, 'inventory_template_redirect') );
        
        add_action('wp_ajax_search_ajax', array($this, 'plugins_inventory_search_ajax') );
        add_action('wp_ajax_nopriv_search_ajax', array($this, 'plugins_inventory_search_ajax') );
        
        // Initialize Widget
        add_action('widgets_init', function(){
            register_widget('DMMInventoryWidget');
        });
        
	} // End __construct ()
	
	public function inventory_get_header()
	{
        global $wp_query, $post;
        $template = get_post_meta( $post->ID, '_wp_page_template', true );

        if($template == 'page-inventory.php') {
            ini_set('max_execution_time', '120');
            require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/lib/search-helper.class.php';  
            $sh = new Search_Helper();
            $sh->load_inventory_in_post($post);
        }
        elseif($template == 'page-inventory-details.php') {
            add_filter( 'wp_seo_get_bc_title', array($this, 'plugins_inventory_details_breadcrumb') );
            ini_set('max_execution_time', '120');
            require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/lib/search-helper.class.php';
            $sh = new Search_Helper();
            $sh->load_boat_details_in_post($post);
        }
	}
	
	/**
	 * Override last breadcrumb item of yoast
	 * 
	 * @param string $title
	 * @return string
	 */
	public function plugins_inventory_details_breadcrumb($title) 
	{
	    global $post;
	    
	    $title = ($post->post_name == 'boats-for-sale-details') ? 
	       $post->post_title : $title;
	    
	    return $title;
	}
	
	/**
	 * Ajax entry point for search URL generator
	 */
	public function plugins_inventory_search_ajax()
	{
        $data = $_REQUEST['data'];
	    $url = Inventory_Helper::generate_search_url($data);
        echo $url;
	    wp_die();
	}

	/**
	 * Create table structure for inventory plugin
	 */
	public function table_install () {
        global $wpdb;

        $table_name = $wpdb->prefix . "inventory";
        $charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
          id int NOT NULL,
          page text NOT NULL,
          new_used text NOT NULL,
          manufacturers text NOT 
          NULL,
          UNIQUE KEY id (id)
        ) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

    }
    
    /**
     * Pull the PDF of boat details when format=pdf param is specified
     */
    public function inventory_template_redirect() {
        global $wp_query, $post;
        
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/lib/currencies.class.php';
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/lib/inventory-helper.class.php';
        
        $template = get_post_meta($post->ID, '_wp_page_template', true);
        $is_pdf = (isset($_REQUEST['format']) && $_REQUEST['format'] == 'pdf') ||
            (isset($_REQUEST['pdf']) && $_REQUEST['pdf'] == 1);
    
        if ( $is_pdf && isset($wp_query->query['BoatID']) && $template == 'page-inventory-details.php')
        {
            $params = array();
            
            // currency
            $currency = !empty($_REQUEST['currency']) ? $_REQUEST['currency'] : Inventory_Helper::get_default_currency_symbol();
            
            // units of measure
            $uom = Inventory_Helper::get_units_of_measure();
            if($uom == 'Imperial-UK') {
                $params['locale'] = 'de';
            }
            elseif($uom == 'Metric') {
                $params['locale'] = 'nl';
            }
            
            $boat = Mmp_Api_Helper::get_boat_details($wp_query->query['BoatID'], $currency, $params);
            $categories = !empty($boat['BoatClassCode']) ? implode(', ', $boat['BoatClassCode']) : '-';
            $title = $boat['ModelYear'] . ' ' . $boat['MakeString'] . ' ' . $boat['Model'] . ' - ' . $boat['DocumentID'];
            $boat['referer'] = 'inventory';
            
            if(!defined('CORE_PLUGIN_PATH')) {  
                die('Core plugin disabled!');
            }
            
            ob_start();
            include (get_template_directory() . '/templates/pdf/boat-details.php');
            $html = ob_get_clean();
            
            if(!empty($_REQUEST['debug'])) {
                echo $html;
            }
            else {
                $dompdf = new Dmm_Pdf();
                $dompdf->get_pdf($html, $title . '.pdf');                
            }
            
            exit;
        }
    }    

    /**
     * Create details page and results page
     */
	public function details_page_install () {

	    
	    // Now handle search results page
	    $inventory_search_template = 'page-inventory.php';
	    $pages = Dmm_Url_Helper::get_pages_by_template($inventory_search_template);
	     
	    if(empty($pages)) {
	        $inventory_search_page = array(
	            'post_name' => 'boats-for-sale',
	            'post_title' => 'Boats For Sale',
	            'post_content' => '',
	            'post_status' => 'publish',
	            'post_type' => 'page',
	            'post_author' => 1
	        );
	         
	        $inventory_search_page_id = wp_insert_post( $inventory_search_page, false );
	        update_post_meta($inventory_search_page_id, '_wp_page_template',  $inventory_search_template);
	    }
	    else {
	        $inventory_search_page = current($pages);
	        $inventory_search_page_id = $inventory_search_page->ID;
	    }
	     
	    update_option(INVENTORY_PREFIX . 'search_page_id', $inventory_search_page_id);	    
	    
	    // Handle details page first
	    $detail_page_template = 'page-inventory-details.php';
	    $pages = Dmm_Url_Helper::get_pages_by_template($detail_page_template);
	    
	    if(empty($pages)) {
    		$details_page = array(
    		    'post_name' => 'boats-for-sale-details',
    			'post_title' => 'Inventory Boat Details Page',
    		    'post_content' => '-- This is a placeholder page used by plugins-inventory. Do not remove --',
    			'post_status' => 'publish',
    			'post_type' => 'page',
    			'post_author' => 1,
    		    'post_parent' => $inventory_search_page_id
    		);
    		
    		$details_page_id = wp_insert_post( $details_page, false );
    		update_post_meta($details_page_id, '_wp_page_template',  $detail_page_template);
	    }
	    else {
	        $detail_page = current($pages);
	        $details_page_id = $detail_page->ID;
	    }
	    
	    update_option(INVENTORY_PREFIX . 'detail_page_id', $details_page_id);
	    
	    flush_rewrite_rules();
	}

	public function register_post_type ( $post_type = '', $plural = '', $single = '', $description = '' ) {

		if ( ! $post_type || ! $plural || ! $single ) return;

		$post_type = new Inventory_Plugin_Post_Type( $post_type, $plural, $single, $description );

		return $post_type;
	}


	public function register_taxonomy ( $taxonomy = '', $plural = '', $single = '', $post_types = array() ) {

		if ( ! $taxonomy || ! $plural || ! $single ) return;

		$taxonomy = new Inventory_Plugin_Taxonomy( $taxonomy, $plural, $single, $post_types );

		return $taxonomy;
	}

    // Add Plugin to Sidebar
    public function add_menu_admin () {
        $page = add_options_page( __( 'Inventory', 'inventory-plugin' ) , __( 'Inventory', 'inventory-plugin' ) , 'manage_options' , 'inventory_plugin' ,  array( $this, 'plugin_page' ) );
        add_action( 'admin_print_styles-' . $page, array( $this, 'plugin_scripts' ) );
    }

	//Load Front End Javascript
	public function inventory_enqueue_scripts () {
	    global $post;
	    
	    $template = get_post_meta($post->ID, '_wp_page_template', true);
	    if($template == 'page-inventory.php') {
		  wp_enqueue_script($this->_token . '-frontend', esc_url( $this->scripts_url ) . 'js/frontend' . $this->script_suffix . '.js?ver=' . $this->_version, false, $this->_version);
	    }
	} // End enqueue_scripts ()

	// Load Admin CSS
	public function admin_enqueue_styles ( $hook = '' ) {
		wp_register_style( $this->_token . '-admin', esc_url( $this->scripts_url ) . 'css/admin.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-admin' );
	} // End admin_enqueue_styles ()

	// Load Admin Javascript
	public function admin_enqueue_scripts ( $hook = '' ) {
		wp_register_script( $this->_token . '-admin', esc_url( $this->scripts_url ) . 'js/admin' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-admin' );
	} // End admin_enqueue_scripts ()

	//Main Plugin Instance
	public static function instance ( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance ()

	//Plugin Installation Log
	public function install () {
		$this->_log_version_number();
	} // End install ()

	//Plugin Version Number Log
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	} // End _log_version_number ()

 	// Load Settings Javascript
    public function plugin_scripts () {

        //wp_register_script( $this->parent->_token . '-settings-js', $this->parent->scripts_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
        //wp_enqueue_script( $this->parent->_token . '-settings-js' );
    }

	//add settings link to plugin table

	public function add_admin_link ( $links ) {
		$admin_link = '<a href="admin.php?page=' . $this->parent->_token . '">' . __( 'Settings', 'inventory-plugin' ) . '</a>';
		array_push( $links, $admin_link );
		return $links;
	}

	// Add Language Text Domain

	public function load_localisation () {
		load_plugin_textdomain( 'inventory-plugin', false, dirname( plugin_basename( $this->file ) ) . '/languages/' );
	} // End load_localisation ()

	public function load_plugin_textdomain () {
		$domain = 'inventory-plugin';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/languages/' );
	} // End load_plugin_textdomain ()


	//Build the Page
    public function plugin_page () {

        // Build page HTML
        $html = '<div class="wrap">' . "\n";
            $html .= '<h2>' . __( 'Inventory Display' , 'inventory-plugin' ) . '</h2>' . "\n";

			global $wpdb;

			$table_name = $wpdb->prefix . 'options';
			$option_n = 'option_name';
			$inv_api_key = 'inventory_plugin_api_key';
			$inv_party_id = 'inventory_plugin_party_id';

			$api_key_table_result = $wpdb->get_results( $wpdb->prepare ("SELECT * FROM $table_name WHERE $option_n = %s",$inv_api_key) );
			$party_id_table_result = $wpdb->get_results( $wpdb->prepare ("SELECT * FROM $table_name WHERE $option_n = %s",$inv_party_id) );

			foreach ( $api_key_table_result as $api_key_result ) { $apiKey = $api_key_result->option_value; }
			foreach ( $party_id_table_result as $party_id_result ) { $partyID = $party_id_result->option_value; }

			if ($apiKey && $partyID) {
				$html .= '<div class="intro-text">';
				$html .= '<p>' . __('This plugin controls the addition and removal of an inventory display from pages within your website.', 'inventory-plugin') . '</p>';
				$html .= '<p>' . __('This plugin will allow you to view a list of active inventory displays and the page that inventory is displayed on, the condition (New/Used/Both), a list of Manufactures selected for each display, and an option to remove the inventory display from each page. You will also be able to add a new inventory display, select Page to display inventory on (Pulls a list of the pages in the site), select Condition (New/Used/Both), and choose manufactures to display (Including option of selecting all/none)', 'inventory-plugin') . '</p>';
				$html .= '</div>';
				$html .= '<button id="show-inventories" class="btn">' . __('Show Current Inventories', 'inventory-plugin') . '</button>';
				$html .= '<div id="inventory-content"></div>';
				$html .= '<div id="edit-content"></div>';
				$html .= '<div id="loading-content"></div>';
				$html .= '<button id="add-inventories" class="btn">' . __('Add New Inventory Display', 'inventory-plugin') . '</button>';
				$html .= '<div class="add-new-inventory">';
				$html .= '<div class="inventory-form">';
				$html .= '<div id=add_displays><h3>' . __('Add Inventory displays', 'inventory-plugin') . '</h3></div>';
				$html .= '<form method="post" action="admin.php?page=inventory_plugin&settings-updated=true" id="searchform">' . "\n";
				$html .= '<div id="display-single">';
				$html .= '<p class="option">';
				$html .= '<b>' . __('Choose page to display inventory:', 'inventory-plugin') . '</b> </br></br>';
				$html .= '<select name="page_select">';
				$html .= '<option selected="selected" disabled="disabled" value="">' . esc_attr(__('Select page')) . '</option>';
				$selected_page = get_option('option_key');
				$pages = get_pages();
				foreach ($pages as $page) {
					$option = '<option value="' . $page->ID . ',' . $page->post_title . '" ';
					$option .= ($page->ID == $selected_page) ? 'selected="selected"' : '';
					$option .= '>';
					$option .= $page->post_title;
					$option .= '</option>';
					$html .= $option;
				}
				$html .= '</select>';
				$html .= '</p>';
				$html .= '<p class="option">';
				$html .= '<b>' . __('New or Used Boats:', 'inventory-plugin') . '</b> </br></br>';
				$html .= '<input type="radio" name="new_used" value="new" id="new">';
				$html .= '<label for="new">' . __('New', 'inventory-plugin') . '</label></br>';
				$html .= '<input type="radio" name="new_used" value="used" id="used">';
				$html .= '<label for="used">' . __('Used', 'inventory-plugin') . '</label></br>';
				$html .= '<input type="radio" name="new_used" value="Both" id="both" checked>';
				$html .= '<label for="both">' . __('All', 'inventory-plugin') . '</label></br>';
				$html .= '</p>';
				$html .= '<p class="option">';
				$html .= '<b>' . __('Choose manufacturers to display:', 'inventory-plugin') . '</b> </br></br>';
				$html .= '<div id="manufacturers"></div>';
				$html .= '</p>';
				$html .= '<p class="submit">' . "\n";
				$html .= '<input type="submit" name="submit" class="button-primary" value="Submit" />' . "\n";

				if (isset ($_POST['submit'])) {

					$page_select = explode(',', $_POST['page_select']);
					$page_id = $page_select[0];
					$page_name = $page_select[1];
					$page_name = str_replace('\\', '', $page_name);
					$new_used = $_POST['new_used'];
					$new_used = str_replace('Both', '', $new_used);
					$manufacturers = implode(',', $_POST['manufacturer']);
					$manufacturers = urlencode($manufacturers);

					global $wpdb;

					$table_name = $wpdb->prefix . 'inventory';

					// Prepared Statement to Delete Entry using Page ID

					$wpdb->query($wpdb->prepare(
						"
										DELETE FROM $table_name
										WHERE id = %d
									",
						$page_id
					));

					// Prepared Statement to Insert New Entry
					$wpdb->query($wpdb->prepare(
						"
										INSERT INTO $table_name
										( id, page, new_used, manufacturers )
										VALUES ( %d, %s, %s, %s )
									",
						array(
							$page_id,
							$page_name,
							$new_used,
							$manufacturers
						)
					));
					
					update_post_meta($page_id, '_wp_page_template',  'page-inventory.php');

				}


				//$html .= '<input name="Submit" type="submit" id="remove-inventory" class="button-primary" value="' . esc_attr( __( 'Remove' , 'inventory-plugin' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
				$html .= '</div>';
				$html .= '</form>';
				$html .= '</div>';
				$html .= '</div>';
			}
		else {
			$html .= 'Please enter an API Key and Party ID';
		}
        $html .= '</div>';

        echo $html;

    }


	/**
	 * Add these as part of query string
	 */
	public function inventory_query_vars($vars) {
	    $additional = array('BoatID', 'category_query', 'makemodel_query', 'location_query');
	    $vars = array_merge($vars, $additional);
		return $vars;
	}
	
	/**
	 * URL Rewrites
	 * @param array $rules
	 */
	public function inventory_add_rewrite_rules($rules)
	{
	    $new_rules = array();
	    
	    $search_page_id = get_option(INVENTORY_PREFIX . 'search_page_id', true);
	    $search_page = get_post($search_page_id);
	    
	    // detail page rewrite
	    $detail_page = Dmm_Url_Helper::get_pages_by_template('page-inventory-details.php', true);
	    $regex_detail_page = $search_page->post_name . '/([0-9]+)-([A-Za-z0-9-]+)-([0-9]+)$';
        $new_rules[$regex_detail_page] = 'index.php?page_id=' . $detail_page->ID . '&BoatID=$matches[3]';
	    
        // search page with only condition/category
        $regex_search_page = $search_page->post_name . '/([a-zA-Z0-9-%]+)$';
        $new_rules[$regex_search_page] = 'index.php?page_id=' . $search_page_id . 
            '&category_query=$matches[1]';
        
        // search page with condition/category and make/model
        $regex_search_page = $search_page->post_name . '/([a-zA-Z0-9-%]+)/([a-zA-Z0-9-%+]+)$';
        $new_rules[$regex_search_page] = 'index.php?page_id=' . $search_page_id .
            '&category_query=$matches[1]&makemodel_query=$matches[2]';    
        
        // search page with condition/category, make/model and location
        $regex_search_page = $search_page->post_name . '/([a-zA-Z0-9-%]+)/([a-zA-Z0-9-%+]+)/([a-zA-Z0-9-%.+]+)$';
        $new_rules[$regex_search_page] = 'index.php?page_id=' . $search_page_id .
            '&category_query=$matches[1]&makemodel_query=$matches[2]&location_query=$matches[3]';        
        
	    $rules = $new_rules + $rules;
	    
	    return $rules;	    
	}
	

	
}
