<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 pagination">



	<form name="sortandfilter" id="searchResults" class="search-form-desktop" method="get" action="" >

		<?php

			if (isset($post->inventory['results'])) {

			//Function to display the pagination.  Must be called at ONCE with $isPrimary = true, and then as many other times with $isPrimary = false

			if(!function_exists('showPagination')) {
			function showPagination($all_result, $results_per_page, $isPrimary) {

			//Sort Results

			if ($isPrimary) {
			$sortArray=array(
			"NormPrice|desc"         => __('Price: high to low', 'inventory-plugin'),
			"NormPrice|asc"          => __('Price: low to high', 'inventory-plugin'),
			"NormNominalLength|desc" => __('Length: high to low', 'inventory-plugin'),
			"NormNominalLength|asc"  => __('Length: low to high', 'inventory-plugin'),
			"ModelYear|desc"         => __('Newest', 'inventory-plugin'),
			"ModelYear|asc"          => __('Oldest', 'inventory-plugin'),
			"MakeStringExact|asc"         => __('Make: A to Z', 'inventory-plugin'),
			"MakeStringExact|desc"        => __('Make: Z to A', 'inventory-plugin')
			);
			echo "<div class='sort-text col-lg-1 col-sm-1 hidden-xs'><span>Sort: </span></div>";
			echo "<div class='sort col-md-3 col-lg-2 col-sm-3 hidden-xs'>";
			echo "<select class='form-control sort-dropdown' name='sort'>";
			foreach($sortArray as $value => $text) {
			$selected = '';
			if (isset($_GET['sort']) && $_GET['sort'] == $value) {
			$selected = " selected";
			}
			echo "<option value='$value' $selected>$text</option>";
			}

			echo "</select>";
			echo "</div>";
			echo "<div id='mobile-sort'>";
			echo "<div class='hidden-lg hidden-md hidden-sm'><h2>" . __('Sort By', 'inventory-plugin') . "</h2></div>";
			echo "<div class='hidden-lg hidden-md hidden-sm col-xs-12'>";
			echo "<select class='form-control sort-dropdown' name='sort'>";
			foreach($sortArray as $value => $text) {
			$selected = '';
			if (isset($_GET['sort']) && $_GET['sort'] == $value) {
			$selected = " selected";
			}
			echo "<option value='$value' $selected>$text</option>";
			}

			echo "</select>";
			echo "</div>";
			echo "</div>";

		?>

		<div class="total-result col-md-3 col-sm-4 col-xs-12">

			<div class="result-status">

				<?php

				$start = isset($_GET['start'])?$_GET['start']:null;

				if ($results_per_page > $all_result ) {
				$per_page = $all_result;
				} else {
				$per_page = $results_per_page;
				}

				$results_label = __('%s to %s of [%s Results]', 'inventory-plugin');
				if (($start && ($per_page))) {
				$results_label = sprintf($results_label, $start, ($start + $per_page), $all_result);
				} elseif (empty($start) && isset($per_page)) {
				$results_label = sprintf($results_label, 1, $per_page, $all_result);
				} elseif (isset($start) && empty($per_page)) {
				$results_label = sprintf($results_label, $start, ($start + $per_page), $all_result);
				} else {
				$results_label = sprintf($results_label, 1, 10, $all_result);
				}
				$results_label = str_replace(array('[', ']'), array('<span>', '</span>'), $results_label);
				echo $results_label;
				?>

			</div>

		</div>

		<!-- Results per page -->

		<?php
			}

			if (isset($_GET['start'])){
			$offset=$results_per_page * (($_GET['start']) / $results_per_page);
			}else{
			$offset=0;
			}
			if ($isPrimary) {
			echo '<div id="page-numbers-wrap" class="col-md-6 col-xs-12">';
			} else {
			echo '<div id="page-numbers-wrap">';
			}

			// LARGE DISPLAY PAGINATION

			echo '<div id="page-numbers" class="hidden-sm hidden-xs">';
			if ($isPrimary) {
			echo '<input type="hidden" name="start" value="' . $offset . '" />';
			}

			// list page navgation ([1] 2 3 4 5)
			if (isset($_GET['start'])){
			$currentpage = ceil(($_GET['start'] + 1) / $results_per_page );
			} else {
			$_GET['start'] = 0;
			$currentpage = 1;
			}

			if ($currentpage != 1){
			$previous2 = $currentpage - 2;
			$previous = $currentpage - 1;
			echo '<a rel="prev" href="' . Inventory_Helper::generate_search_url(array('page' => $previous, 'per_page' => $results_per_page), true) . '"><div class="prev glyphicon glyphicon-chevron-left"></div></a>';

			if ($previous2 > 1)
			echo '<a href="' . Inventory_Helper::generate_search_url(array('page' => 1, 'per_page' => $results_per_page), true) . '">1</a>&nbsp;';
			if ($previous2 > 2)
			echo "...&nbsp";
			if ($previous2 > 0)
			echo '<a href="' . Inventory_Helper::generate_search_url(array('page' => $previous2, 'per_page' => $results_per_page), true) . '">' . $previous2 . '</a>&nbsp;';

			echo '<a rel="prev" href="' . Inventory_Helper::generate_search_url(array('page' => $previous, 'per_page' => $results_per_page), true) . '">' . $previous . '</a>&nbsp;';

			} else { echo '<div class="hide glyphicon glyphicon-chevron-left"></div>'; }

			echo '<span>'.$currentpage.'</span>';

			$lastpage=ceil($all_result/$results_per_page);

			if ($currentpage != $lastpage){
			$next = $currentpage + 1;
			$next2 = $currentpage + 2;
			if ($next < $lastpage)
			echo '<a rel="next" href="' . Inventory_Helper::generate_search_url(array('page' => $next, 'per_page' => $results_per_page), true) . '">' . $next . '</a>&nbsp;';
			if ($next2 < $lastpage)
			echo '<a href="' . Inventory_Helper::generate_search_url(array('page' => $next2, 'per_page' => $results_per_page), true) . '">' . $next2 . '</a>&nbsp;';
			if ($next2 < $lastpage - 1)
			echo '<a class="andSome"> ... </a>';
			echo '<a href="' . Inventory_Helper::generate_search_url(array('page' => $lastpage, 'per_page' => $results_per_page), true) . '">' . $lastpage . '</a>&nbsp;';
			echo '&nbsp;&nbsp;<a rel="next" href="' . Inventory_Helper::generate_search_url(array('page' => $next, 'per_page' => $results_per_page), true) . '"><div class="next glyphicon glyphicon-chevron-right"></div></a>';
			}
			echo "</div>";

			// SMALL DISPLAY PAGINATION

			echo '<div id="page-numbers-small" class="hidden-lg hidden-md">';
			if ($isPrimary) {
			echo '<input type="hidden" name="start" value="' . $offset . '" />';
			}

			if (isset($_GET['start'])){
			$currentpage = ceil(($_GET['start'] + 1) / $results_per_page );
			} else {
			$currentpage = 1;
			}

			if ($currentpage != 1){
			$previous = $currentpage - 1;
			echo '<a rel="prev" href="' . Inventory_Helper::generate_search_url(array('page' => $previous, 'per_page' => $results_per_page), true) . '">';
			echo '<button type="button" class="col-xs-6 prev-btn pag-btn btn btn-default"><div class="large-prev glyphicon glyphicon-chevron-left"></div> ' . __('Previous', 'inventory-plugin') . '</button></a>';

			} else { echo '<div class="hide glyphicon glyphicon-chevron-left"></div>'; }

			$lastpage=ceil($all_result / $results_per_page);

			if ($currentpage != $lastpage){
			$next = $currentpage + 1;
			echo '&nbsp;&nbsp;<a rel="next" href="' . Inventory_Helper::generate_search_url(array('page' => $next, 'per_page' => $results_per_page), true) . '">';
			echo '<button type="button" class="col-xs-6 next-btn pag-btn btn btn-default">' . __('Next', 'inventory-plugin') . ' <div class="large-next glyphicon glyphicon-chevron-right"></div></button></a>';
			}
			echo "</div>";

			}
			} // end showPagination
			} // end if exists showPagination

		?>

		<?php if (isset($post->inventory['results'])) { showPagination($post->inventory['all_result'], $post->inventory['results_per_page'], true); } ?>

		<!--
		<input type="hidden" name="category" id="category" value="<?php if (isset($selected_category)) { echo $selected_category; } ?>" />
		<input type="hidden" name="BoatClassCode" id="BoatClassCode" value="<?php if (array_key_exists('BoatClassCode', $post->inventory['params'] )) { echo $post->inventory['params']['BoatClassCode']; } ?>"/>
		<input type="hidden" name="MakeString" id="MakeString" value="<?php echo Inventory_Helper::get_search_permalink_params('make', '') ?>"/>
		<input type="hidden" name="ModelExact" id="ModelExact" value="<?php echo Inventory_Helper::get_search_permalink_params('model', '') ?>"/>
		<input type="hidden" name="condition" id="condition" value="<?php echo Inventory_Helper::get_search_permalink_params('condition', '') ?>"/>
		<input type="hidden" name="BoatStateCode" id="BoatStateCode" value="<?php if (array_key_exists('BoatStateCode', $post->inventory['params'])) { echo $post->inventory['params']['BoatStateCode']; } ?>"/>
		<input type="hidden" name="BoatCountryID" id="BoatCountryID" value="<?php if (array_key_exists('BoatCountryID', $post->inventory['params'])) { echo $post->inventory['params']['BoatCountryID']; } ?>"/>
		<input type="hidden" name="BoatCityName" id="BoatCityName" value="<?php if (array_key_exists('BoatCityName', $post->inventory['params'])) { echo $post->inventory['params']['BoatCityName']; } ?>"/>
		<input type="hidden" name="BoatHullMaterialCode" id="BoatHullMaterialCode" value="<?php if (array_key_exists('BoatHullMaterialCode', $post->inventory['params'])) { echo $post->inventory['params']['BoatHullMaterialCode']; } ?>"/>
		-->

	</form>

</div>
