<?php
/**
 * Template Name: Inventory Results Page
 * Display inventory results from inventory plugin
 */
the_post();

$selected_country   = Inventory_Helper::get_search_permalink_params('country');
$selected_state     = Inventory_Helper::get_search_permalink_params('state');
$selected_city      = Inventory_Helper::get_search_permalink_params('city');
$selected_condition = Inventory_Helper::get_search_permalink_params('condition');
$selected_category  = Inventory_Helper::get_search_permalink_params('category');
$selected_make      = Inventory_Helper::get_search_permalink_params('make');
$selected_make      = Inventory_Helper::get_search_permalink_params('model');
?>


<a href="#" class="go-top btn btn-primary btn-sm"><?php _e('Back to top'); ?></a>
<div class="inventory-display clearfix" id="inventory-display" xmlns="http://www.w3.org/1999/html">
    <div class="hidden-lg hidden-md hidden-sm col-xs-12" id="show-search">
        <button type="submit" id="show-search-button" class="col-xs-12 btn btn-default"><?php _e('Sort and Refine', 'inventory-plugin'); ?></button>
    </div>

    <div class="hidden-lg hidden-md hidden-sm hidden-xs" id="hide-search">
    	<button type="submit" id="hide-search-button" class="col-xs-12 btn btn-default"><?php _e('Hide Search', 'inventory-plugin'); ?></button>
    </div>

    <div class="col-sm-3 hidden-xs" id="boat-search">
        <!-- Quick Search Form -->
        <?php require(locate_template('inventory-search-form.php')); ?>
    
        <!-- Facets -->
    	<div class="search-boats">
            <?php require(locate_template('inventory-filter-form.php')); ?>
    	</div>   
    </div>
    <!-- Inventory Nav -->
    <?php require(locate_template('inventory-sort-nav.php')); ?>

	<?php if (isset($post->inventory['results'])) { echo '</div>'; } ?>
	
	<!-- Boat Results -->
    <?php require(locate_template('inventory-boat-results.php'))?>
    
    <!-- Pagination -->
	<?php 
	if (isset($post->inventory['results'])) { 
	    showPagination($post->inventory['all_result'], $post->inventory['results_per_page'], false); 
	} 
	?>

</div>

</div>

</div>

<script type="text/javascript">
var inventory_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
jQuery(document).ready(function(){
	$(window).scroll(function() {
		if ($(this).scrollTop() > 200) {
			$('.go-top').fadeIn(500);
		} else {
			$('.go-top').fadeOut(300);
		}
	});
	// Animate the scroll to top
	$('.go-top').click(function(event) {
		event.preventDefault();
		$('html, body').animate({scrollTop: 0}, 300);
	})	
	
	searchObj = inventorysearch();
	searchObj.init('<?php echo Inventory_Helper::get_quick_search_url() ?>');
});
</script>