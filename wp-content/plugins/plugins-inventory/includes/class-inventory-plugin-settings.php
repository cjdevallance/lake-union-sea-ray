<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Inventory_Plugin_Settings {


	/**
	 * The single instance of WordPress_Plugin_Template_Settings.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The main plugin object.
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	public function __construct ( $parent ) {
		$this->parent = $parent;

		$this->base = 'inventory_plugin_';

		// Initialise settings
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_settings_link' ) );
	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init_settings () {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item () {
		$page = add_options_page( __( 'Inventory Settings', 'inventory-plugin' ) , __( 'Inventory Settings', 'inventory-plugin' ) , 'manage_options' , $this->parent->_token . '_settings' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}

	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets () {

		// We're including the WP media scripts here because they're needed for the image upload field
		// If you're not including an image upload then you can leave this function call out
		wp_enqueue_media();

		wp_register_script( $this->parent->_token . '-settings-js', esc_url($this->parent->scripts_url ) . 'js/settings' . $this->parent->script_suffix . '.js', array( 'jquery' ), $this->parent->_version );
		wp_enqueue_script( $this->parent->_token . '-settings-js' );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link ( $links ) {
		$settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __( 'Settings', 'inventory-plugin' ) . '</a>';
		array_push( $links, $settings_link );
		return $links;
	}
	
	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {

	    $selected_currencies = get_option('inventory_plugin_currency_checkboxes');
	    $selected_length_units = get_option('inventory_plugin_length_checkboxes');
	    
		$settings['standard'] = array(
			'title'					=> __( 'General Settings', 'inventory-plugin' ),
			'description'			=> __( 'Select the general options for the inventory plugin.', 'inventory-plugin' ),
			'fields'				=> array(
				array(
					'id' 			=> 'party_id',
					'label'			=> __( 'Party ID', 'inventory-plugin' ),
					'description'	=> __( 'Select the Provisioning Party ID to use in the inventory display.', 'inventory-plugin' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '*Required', 'inventory-plugin' )
				),
				array(
					'id' 			=> 'api_key',
					'label'			=> __( 'API Key', 'inventory-plugin' ),
					'description'	=> __( 'Select the API Key to use in the inventory display.', 'inventory-plugin' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '*Required', 'inventory-plugin' )
				)
			)
		);

		$fields = array();
		
		$fields[] = array(
		    'id' 			=> 'currency_checkboxes',
		    'label'			=> __( 'Currency', 'inventory-plugin' ),
		    'description'	=> __( 'Select the currency/currencies to use in the inventory display.', 'inventory-plugin' ),
		    'type'			=> 'checkbox_multi',
		    'options'		=> array( 'dollar' => __( 'Dollar', 'inventory-plugin'), 'pound' => __( 'Pound', 'inventory-plugin'), 'euro' => __( 'Euro', 'inventory-plugin') ),
		    'default'		=> array( 'dollar', 'pound', 'euro' )
		);
		
		// default currency
		if(!empty($selected_currencies)) {
		    $available_currencies = array();
		    $default_currency = current($selected_currencies);
		    foreach($selected_currencies as $currency) {
		        $available_currencies[$currency] = $this->get_currency_label($currency);
		    }
		    
    		$fields[] = array(
    		    'id' 			=> 'default_currency',
    		    'label'			=> __( 'Default Currency', 'inventory-plugin' ),
    		    'description'	=> __( 'Default currency for selected currencie(s)', 'inventory-plugin' ),
    		    'type'			=> 'radio',
    		    'options'		=> $available_currencies,
    		    'default'		=> $default_currency
    		);	
		}
		
		$fields[] = array(
			'id' 			=> 'length_checkboxes',
			'label'			=> __( 'Length Measurement', 'inventory-plugin' ),
			'description'	=> __( 'Select the length measurement to use in the inventory display.', 'inventory-plugin' ),
			'type'			=> 'checkbox_multi',
		    'disabled'       => true,
			'options'		=> array( 'feet' => __( 'Feet', 'inventory-plugin'), 'meters' => __( 'Meters', 'inventory-plugin') ),
			'default'		=> array( 'feet', 'meters' )
		);
		
		// units of measurement: default_length_unit
	    $default_unit = !empty($selected_length_units) && count($selected_length_units) > 0 ? 
	       current($selected_length_units) : 
	       'Imperial-US';	
	    
		$fields[] = array(
	        'id' 			=> 'uom',
	        'label'			=> __( 'Units of measurement', 'inventory-plugin' ),
	        'description'	=> __( 'Units of measurement displayed in detail pages and specifications', 'inventory-plugin' ),
	        'type'			=> 'radio',
	        'options'		=> array( 
	                               'Imperial-US' => __( 'Imperial US', 'inventory-plugin'), 
	                               'Imperial-UK' => __( 'Imperial UK', 'inventory-plugin'),
	                               'Metric' => __( 'Metric', 'inventory-plugin'),
	                           ),
	        'default'		=> $default_unit
	    );
		
		$fields[] = array(
			'id' 			=> 'location_radios',
			'label'			=> __( 'Location Options', 'inventory-plugin' ),
			'description'	=> __( 'Select the location options to use in the inventory display.', 'inventory-plugin' ),
			'type'			=> 'radio',
			'options'		=> array( 'city/country' => __( 'City/Country', 'inventory-plugin'), 'city/state' => __( 'City/State', 'inventory-plugin'), 'city/state/country' => __( 'City/State/Country', 'inventory-plugin'), 'country' => __( 'Country', 'inventory-plugin') ),
			'default'		=> 'city/country'
		);
		
		$settings['Localisation'] = array(
			'title'					=> __( 'Localisation Settings', 'inventory-plugin' ),
			'description'			=> __( 'Select the localisation options for the inventory plugin.', 'inventory-plugin' ),
			'fields'				=> $fields
		);

		$settings = apply_filters( $this->parent->_token . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings () {
		if ( is_array( $this->settings ) ) {

			foreach ( $this->settings as $section => $data ) {

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->base . $field['id'];
					register_setting( $this->parent->_token . '_settings', $option_name, $validation );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), $this->parent->_token . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ) );

					add_settings_field('site_logo', 'Logo', 'site_logo_callback_function', 'general', 'default');
					register_setting('general','site_logo');
				}

			}
		}
	}

	public function settings_section ( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page () {

		// Build page HTML
		$html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
		$html .= '<h2>' . __( 'Inventory Settings' , 'inventory-plugin' ) . '</h2>' . "\n";

		$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

		// Get settings fields
		ob_start();
		settings_fields( $this->parent->_token . '_settings' );
		do_settings_sections( $this->parent->_token . '_settings' );
		$html .= ob_get_clean();

		$html .= '<p class="submit">' . "\n";
		$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'inventory-plugin' ) ) . '" />' . "\n";
		$html .= '</p>' . "\n";
		$html .= '</form>' . "\n";
		$html .= '</div>' . "\n";

		echo $html;
	}

	/**
	 * Main WordPress_Plugin_Template_Settings Instance
	 *
	 * Ensures only one instance of WordPress_Plugin_Template_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WordPress_Plugin_Template()
	 * @return Main WordPress_Plugin_Template_Settings instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', $this->parent->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', $this->parent->_version );
	} // End __wakeup()

	/**
	 * Get showrooms landing page slug
	 *
	 * @return string
	 */
	public static function get_landing_page_slug()
	{
		$landing_page_id = get_option(INVENTORY_PLUGIN_PREFIX . 'landing_page_id');
		if(!empty($landing_page_id)) {
			$landing_page = get_post($landing_page_id, ARRAY_A);
		}

		$landing_page_slug = !empty($landing_page['post_name']) ?
			$landing_page['post_name'] :
			'inventory-plugin';

		return $landing_page_slug;
	}
	
	/**
	 * Get localized currency label
	 *
	 * @param string $label
	 */
	private function get_currency_label($label)
	{
	    $output = '';
	    switch($label) {
	        case 'dollar':
	            $output = __('Dollar', 'inventory_plugin');
	            break;
	        case 'pound':
	            $output = __('Pound', 'inventory_plugin');
	            break;
	        case 'euro':
	            $output = __('Euro', 'inventory_plugin');
	            break;
	    }
	     
	    return $output;
	}	

}