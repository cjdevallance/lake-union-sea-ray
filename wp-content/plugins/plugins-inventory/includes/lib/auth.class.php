<?php
class Auth {
        private static $apiKey;

                public function __construct() {

                        require_once( ABSPATH . 'wp-config.php');

                        global $wpdb;

                        $table_name = $wpdb->prefix . 'options';

                        $table_result = $wpdb->get_results(
                            "
                                    SELECT *
                                    FROM $table_name
                                    WHERE option_name = 'inventory_plugin_api_key'
                                    "
                        );

                        foreach ( $table_result as $result ) {
                            self::$apiKey = $result->option_value;
                        }
                }

        public function getApiKey() {
                return self::$apiKey;
        }

}
