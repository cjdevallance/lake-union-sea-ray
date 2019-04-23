<?php
class Cond {
    private static $cond;

    public function __construct() {

        if ( isset($_GET['condition']) and $_GET['condition'] ) {
            self::$cond = $_GET['condition'];
        }

        else {

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
                self::$cond = $result->new_used;
            }
        }

        //self::$cond = str_replace('Both', '', $cond);

    }
    public function getCond() {
        return self::$cond;
    }
}

