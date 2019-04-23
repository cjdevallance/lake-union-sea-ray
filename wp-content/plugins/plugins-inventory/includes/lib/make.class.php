<?php
class Make {
    private static $make;

    public function __construct() {

        require_once(  ABSPATH . 'wp-config.php');

        global $wpdb;

        $id = get_the_ID();

        $table_name = $wpdb->prefix . 'inventory';

        $table_result = $wpdb->get_results(
            "
                    SELECT *
                    FROM $table_name
                    WHERE id = $id
                    "
        );

        foreach ( $table_result as $result ) {
            self::$make = $result->manufacturers;
        }
        
    }
    public function getMake() {
        return self::$make;
    }
}

