<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

ini_set('max_execution_time', '120');
require_once("../includes/lib/search.class.php");
$search = new Search();

$criteria = $_SERVER["QUERY_STRING"];
$fields = NULL;
$makestring = "MakeStringExact";
$facetFields = array($makestring);
$debug=false;

$searchResult = $search->search($criteria, $fields, $facetFields, $debug);

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
    $manufacturer2 = explode('%2C', $manufacturer_list);
}

?>

<div class="checkbox">
<input type="checkbox" name="manufacturer[]" id="select_all" value="" checked />
<label for="select_all">Select All/None</label></br></br>
<?php if ( $manufacturer_array ) {
    ksort( $manufacturer_array );
    foreach ($manufacturer_array as $key => $make) {
        $checked = in_array($key, $manufacturer2) ? ' checked' : '';
        echo '<div class="makeinput">';
        echo '<input type="checkbox" name="manufacturer[]" class="makecheck" id="' . $key . '" value="' . $key . '"' . $checked . ' />';
        echo '<label for="' . $key . '">' . $key . ' ' . '(' . $make . ')' . '</label>';
        echo '</div>';


    }
} else { echo 'No Boats Available'; }
?>
</div>