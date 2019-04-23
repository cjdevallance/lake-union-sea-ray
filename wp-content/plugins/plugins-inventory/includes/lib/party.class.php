<?php
class Party {

    private static $partyID;

    public function __construct() {

        require_once( ABSPATH . 'wp-config.php');

        global $wpdb;

        $table_name = $wpdb->prefix . 'options';

        $table_result = $wpdb->get_results(
            "
                                    SELECT *
                                    FROM $table_name
                                    WHERE option_name = 'inventory_plugin_party_id'
                                    "
        );

        foreach ( $table_result as $result ) {
            self::$partyID = $result->option_value;
        }
    }

    public function getPartyID() {
        return self::$partyID;
    }
}

