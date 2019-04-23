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

global $wpdb;

$table_name = $wpdb->prefix . 'inventory';

$page_id = $_GET['identity'];

$table_result = $wpdb->get_results ( $wpdb->prepare (
    "
            SELECT *
            FROM $table_name
            WHERE id = %d
            ",
    $page_id
) ) ;

$count_results = 0;
foreach ( $table_result as $result ) {
    $count_results++;
    $id = $result->id;
    $name = $result->page;
    $cond = $result->new_used;
    $manufacturer_list = $result->manufacturers;
    $manufacturer2 = urldecode($manufacturer_list);
    $manufacturer2 = explode(',', $manufacturer2);
}
    // Build page HTML
    $html .= '<div class="inventory-form">';
    $html .= '<div id=add_displays><h3>' . __( 'Edit Inventory display' , 'inventory-plugin' ) . '</h3></div>';
    //$html .= '<form method="post" action="inventory-edit.php?id='. $page_id. '" id="editform">' . "\n";
    $html .= '<form method="post" action="" id="editform">' . "\n";
    $html .= '<div id="display-single">';
    $html .= '<p class="option">';
    $html .= '<b>' . __( 'Page to display inventory:' , 'inventory-plugin' ) . '</b> </br></br>';
    $html .= '<select name="page_select">';
    $html .= '<option selected="selected" disabled="disabled" value="">' . esc_attr( __( 'Select page' ) ) . '</option>';
    $pages = get_pages();
    foreach ( $pages as $page ) {
        $option = '<option value="' . $page->ID . ','. $page->post_title .'" ';
        $option .= ( $page->ID == $id ) ? 'selected="selected"' : '';
        $option .= '>';
        $option .= $page->post_title;
        $option .= '</option>';
        $html .= $option;
    }
    $html .= '</select>';
    $html .= '</p>';
    $html .= '<p class="option">';
    $html .= '<b>' . __( 'New or Used Boats:' , 'inventory-plugin' ) . '</b> </br></br>';
    if ($cond == "new") { $new_checked = "checked"; }
    if ($cond == "used") { $used_checked = "checked"; }
    if ($cond == "Both") { $both_checked = "checked"; }
    $html .= '<input type="radio" name="new_used" value="new" class="edit_new" id="edit_new-'.$page_id.'" ' . $new_checked . '>';
    $html .= '<label for="edit_new-'.$page_id.'">' . __( 'New' , 'inventory-plugin' ) . '</label></br>';
    $html .= '<input type="radio" name="new_used" value="used" class="edit_used" id="edit_used-'.$page_id.'" ' . $used_checked . '>';
    $html .= '<label for="edit_used-'.$page_id.'">' . __( 'Used' , 'inventory-plugin' ) . '</label></br>';
    $html .= '<input type="radio" name="new_used" value="Both" class="edit_both" id="edit_both-'.$page_id.'" ' . $both_checked . '>';
    $html .= '<label for="edit_both-'.$page_id.'">' . __( 'All' , 'inventory-plugin' ) . '</label></br>';
    $html .= '</p>';
    $html .= '<p class="option">';
    $html .= '<b>' . __( 'Choose manufacturers to display:' , 'inventory-plugin' ) . '</b> </br></br>';
    $html .= '<div id="edit-manufacturers">';
    $html .= '<div class="checkbox">';
    $html .= '<input type="checkbox" name="manufacturer[]" id="select_all" value="" checked />';
    $html .= '<label for="select_all">' . __( 'Select All/None' , 'inventory-plugin' ) . '</label></br></br>';
    if ( $manufacturer_array ) {
        ksort( $manufacturer_array );
        foreach ($manufacturer_array as $key => $make) {
            $checked = in_array($key, $manufacturer2) ? ' checked' : '';
                    $html .= '<div class="makeinput">';
                    $html .= '<input type="checkbox" name="manufacturer[]" class="makecheck" id="' . $key . '" value="' . $key . '"' . $checked . ' />';
                    $html .= '<label for="' . $key . '">' . $key . ' ' . '(' . $make . ')' . '</label>';
                    $html .= '</div>';


        }
    } else { $html .= __( 'No Boats Available' , 'inventory-plugin' ); }
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div id="edit-manufacturers-change"></div>';
    $html .= '</p>';
    $html .= '<p class="submit">' . "\n";
    $html .= '<input type="submit" name="submit" class="button-primary" value="Submit" />';
    $html .= '<div id="edit-cancel-button" class="button-primary">' . __( 'Cancel' , 'inventory-plugin' ) . '</div>' . "\n";
        //$html .= '<input name="Submit" type="submit" id="remove-inventory" class="button-primary" value="' . esc_attr( __( 'Remove' , 'inventory-plugin' ) ) . '" />' . "\n";
    $html .= '</p>' . "\n";
    $html .= '</div>';
    $html .= '</form>';
    $html .= '</div>';

    echo $html;


