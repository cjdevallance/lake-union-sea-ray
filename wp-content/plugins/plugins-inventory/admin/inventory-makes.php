<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

ini_set('max_execution_time', '120');

require_once( ABSPATH . 'wp-content/plugins/plugins-inventory/includes/lib/make-search.class.php' );

$search = new MakeSearch();

$criteria = $_SERVER["QUERY_STRING"];
$fields = NULL;
$makestring = "MakeStringExact";
$facetFields = array($makestring);
$debug=false;

$searchResult = $search->makesearch($criteria, $fields, $facetFields, $debug);

if (array_key_exists('facets', $searchResult[$search->BODY])) {
    $manufacturer_array = ($searchResult[$search->BODY]['facets']['MakeStringExact']);
}

    $content  = '<div class="total_manufacturers">Manufacturers Available: ';
    if ($manufacturer_array) {
        $content .= '<span>' . array_sum($manufacturer_array) . '</span>';
    }
    $content .= '</div>';
    $content .= '<div class="checkbox">';
    $content .= '<input type="checkbox" name="manufacturer[]" id="select_all" value="" checked />';
    $content .= '<label for="select_all">' . __( 'Select All/None' , 'inventory-plugin' ) . '</label></br></br>';
    if ( $manufacturer_array ) {
        ksort( $manufacturer_array );
        foreach ($manufacturer_array as $key => $make) {
            $content .= '<div class="makeinput">';
            $content .= '<input type="checkbox" name="manufacturer[]" class="makecheck" id="' . $key . '" value="' . $key . '" checked />';
            $content .= '<label for="' . $key . '">' . $key . ' ' . '(' . $make . ')' . '</label>';
            $content .= '</div>';
        }
    } else { $content .=  __( 'No Boats Available' , 'inventory-plugin' ); }
    $content .= '</div>';


echo $content;

