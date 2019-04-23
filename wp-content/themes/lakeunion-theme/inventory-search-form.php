<?php
$selected_country   = Inventory_Helper::get_search_permalink_params('country');
$selected_state     = Inventory_Helper::get_search_permalink_params('state');
$selected_city      = Inventory_Helper::get_search_permalink_params('city');
$selected_condition = Inventory_Helper::get_search_permalink_params('condition');
$selected_category  = Inventory_Helper::get_search_permalink_params('category');
$selected_make      = Inventory_Helper::get_search_permalink_params('make');
$selected_model     = Inventory_Helper::get_search_permalink_params('model');

?>
<form name="searchResults" id="searchResults" class="search-boats desktop-form">

	<div class="hidden-xs primary-search">

		<div>
		<h4><?php _e('Search By', 'inventory-plugin'); ?></h4>
		</div>



		<!-- Desktop Make/Model View -->

		<div class=" hidden-xs makemodel filter">

		<!-- Desktop Header -->
		<div class="hidden-xs"><h5><?php _e('Make', 'inventory-plugin'); ?></h5></div>

			<div id="keyword">
				<input type="text" id="makeandmodel" name="MakeString"
				    class="form-control form-control-desktop input-md" placeholder="<?php _e('Search Make', 'inventory-plugin'); ?>"
				    value="<?php echo $selected_make; ?>" />

				<!-- Button to remove keyword -->
				<?php if(!empty($selected_make)) {
					echo '<span><a>X</a></span>';
				} ?>

			</div>

		</div>



		<!-- Desktop Price View -->

		<div class="hidden-xs search-by filter row">

		<!-- Desktop Header -->

		<div class="hidden-xs col-lg-12 col-col-md-12 col-sm-12 col-xs-12"><h5><?php _e('Price', 'inventory-plugin'); ?></h5></div>


		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 price-select">

			<?php echo Inventory_Helper::get_currency_dropdown('currency', 'currency', 'form-control-desktop input-md'); ?>

		</div>

		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 price-input">

			<div id="min-price">

				<input type="text" id="minprice" class="form-control form-control-desktop input-md" name="min-price" placeholder="<?php _e('From', 'inventory-plugin'); ?>" <?php if (isset($_GET['min-price']) and $_GET['min-price']) { echo 'value="' . $_GET['min-price'] . '"'; } ?>>

					<!-- Button to remove keyword -->

					<?php echo Inventory_Helper::get_facet_deselector('min-price'); ?>

			</div>

		</div>

		<div class="price-input col-lg-4 col-md-4 col-sm-12 col-xs-12">

			<div id="max-price">

				<input type="text" id="maxprice" class="form-control form-control-desktop input-md" name="max-price" placeholder="<?php _e('To', 'inventory-plugin'); ?>" <?php if (isset($_GET['max-price']) and $_GET['max-price']) { echo 'value="' . $_GET['max-price'] . '"'; } ?>>

					<?php echo Inventory_Helper::get_facet_deselector('max-price'); ?>

			</div>

		</div>

		<input type="hidden" name="price" id="boat-price" />

		</div>

		<!-- Desktop Length View -->

		<div class="hidden-xs search-by filter row">


		<!-- Desktop Header -->

		<div class="hidden-xs col-lg-12 col-md-12 col-sm-12 col-xs-12"><h5><?php _e('Length', 'inventory-plugin'); ?></h5></div>


				<div class="length-select col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<?php echo Inventory_Helper::get_length_dropdown('unit', 'unit', 'form-control-desktop'); ?>
				</div>

				<div class="length-input col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div id="min-length">
						<input type="text" id="minlength" class="form-control form-control-desktop input-md" name="min-length" placeholder="<?php _e('From', 'inventory-plugin'); ?>" <?php if (isset($_GET['min-length']) and $_GET['min-length']) { echo 'value="' . $_GET['min-length'] . '"'; } ?>>
                        <?php echo Inventory_Helper::get_facet_deselector('min-length'); ?>
					</div>

				</div>

				<div class="length-input col-lg-4 col-md-4 col-sm-12 col-xs-12">

					<div id="max-length">
						<input type="text" id="maxlength" class="form-control form-control-desktop input-md" name="max-length" placeholder="<?php _e('To', 'inventory-plugin'); ?>" <?php if (isset($_GET['max-length']) and $_GET['max-length']) { echo 'value="' . $_GET['max-length'] . '"'; } ?>>
                        <?php echo Inventory_Helper::get_facet_deselector('max-length'); ?>
					</div>

				</div>

			<input type="hidden" name="length" id="boat-length" />

		</div>



		<!-- Desktop Year View -->

		<div class="hidden-xs search-by filter row">

		<!-- Desktop Header -->

		<div class="hidden-xs col-lg-12 col-md-12 col-sm-12 col-xs-12"><h5><?php _e('Year', 'inventory-plugin'); ?></h5></div>

				<div class="year-input col-lg-6 col-md-6 col-sm-12 col-xs-12">

					<div id="min-year">
						<input type="text" id="minyear" class="form-control form-control-desktop input-md" name="min-year" placeholder="<?php _e('From', 'inventory-plugin'); ?>" <?php if (isset($_GET['min-year']) and $_GET['min-year']) { echo 'value="' . $_GET['min-year'] . '"'; } ?>>
                        <?php echo Inventory_Helper::get_facet_deselector('min-year'); ?>
					</div>

				</div>

				<div class="year-input col-lg-6 col-md-6 col-sm-12 col-xs-12">

					<div id="max-year">
						<input type="text" id="maxyear" class="form-control form-control-desktop input-md" name="max-year" placeholder="<?php _e('To', 'inventory-plugin'); ?>" <?php if (isset($_GET['max-year']) and $_GET['max-year']) { echo 'value="' . $_GET['max-year'] . '"'; } ?>>
                        <?php echo Inventory_Helper::get_facet_deselector('max-year'); ?>
					</div>

				</div>


		</div>

		<div class="search-btn">

			<button id="search-btn-desktop" type="button" class=" btn btn-primary search-btn-2"><?php _e('Update Results', 'inventory-plugin'); ?></button>

		</div>



    <input type="hidden" name="country" id="country" value="<?php echo Inventory_Helper::get_search_permalink_params('country') ?>" />
	<input type="hidden" name="state" id="state" value="<?php echo Inventory_Helper::get_search_permalink_params('state') ?>" />
	<input type="hidden" name="city" id="city" value="<?php echo Inventory_Helper::get_search_permalink_params('city') ?>" />
	<input type="hidden" name="category" id="category" value="<?php echo Inventory_Helper::get_search_permalink_params('category') ?>" />
	<input type="hidden" name="condition" id="condition" value="<?php echo Inventory_Helper::get_search_permalink_params('condition') ?>" />
	<input type="hidden" name="model" id="model" value="<?php echo Inventory_Helper::get_search_permalink_params('model') ?>" />
	<input type="hidden" name="sort" id="sort" value="<?php if (isset($_GET['sort']) and $_GET['sort']) { echo $_GET['sort']; } ?>" />
	<input type="hidden" name="option" id="option" value="<?php if (isset($_GET['option']) and $_GET['option']) { echo $_GET['option']; } ?>" />

</form>

<form name="MobilesearchResults" id="searchResults" class="search-boats mobile-form">

	<div class="hidden-lg hidden-md hidden-sm primary-search">

		<h2><?php _e('Search By', 'inventory-plugin'); ?></h2>

		<!-- Mobile Header/Button -->
		<div class="hidden-lg hidden-md hidden-sm show-filter" id="show-makemodel"><?php _e('Make', 'inventory-plugin'); ?></div>

		<!-- Mobile Make/Model View -->
		<div class="makemodel filter" id="makemodel-filter">

			<div id="keyword">
				<input type="text" id="makeandmodel" name="MakeString"
				 class="form-control form-control-mobile input-md"
				 placeholder="<?php _e('Search Make', 'inventory-plugin'); ?>"
				 value="<?php echo $selected_make; ?>" />

				<!-- Button to remove keyword -->
				<?php if(!empty($selected_make)) {
					echo '<span><a>X</a></span>';
				} ?>
			</div>

		</div>

		<!-- Mobile Header/Button -->
		<div class="hidden-lg hidden-md hidden-sm show-filter" id="show-price">Price</div>

		<!-- Mobile Price View -->

		<div class="hidden-lg hidden-md hidden-sm row search-by filter" id="price-filter">

			<div class="">

				<div class="price-select">
                    <?php echo Inventory_Helper::get_currency_dropdown('currency', 'currency', 'form-control-mobile'); ?>
				</div>

				<div class="price-input">

					<div id="min-price">

						<input type="text" id="minprice" class="form-control form-control-mobile input-md" name="min-price" placeholder="<?php _e('From', 'inventory-plugin'); ?>" <?php if (isset($_GET['min-price']) and $_GET['min-price']) { echo 'value="' . $_GET['min-price'] . '"'; } ?>>

						<!-- Button to remove keyword -->
                        <?php echo Inventory_Helper::get_facet_deselector('min-price'); ?>

					</div>

				</div>

				<div class=" price-input">

					<div id="max-price">
						<input type="text" id="maxprice" class="form-control form-control-mobile input-md" name="max-price" placeholder="<?php _e('To', 'inventory-plugin'); ?>" <?php if (isset($_GET['max-price']) and $_GET['max-price']) { echo 'value="' . $_GET['max-price'] . '"'; } ?>>
                        <?php echo Inventory_Helper::get_facet_deselector('max-price'); ?>
					</div>

				</div>

			</div>

		</div>

		<!-- Mobile Header/Button -->

		<div class="hidden-lg hidden-md hidden-sm show-filter" id="show-length"><?php _e('Length', 'inventory-plugin'); ?></div>

		<!-- Mobile Length View -->

		<div class="hidden-lg hidden-md hidden-sm search-by filter" id="length-filter">

			<div class="">

				<div class="length-select">
					<?php echo Inventory_Helper::get_length_dropdown('unit', 'unit', 'form-control-mobile'); ?>
				</div>

				<div class="length-input">

					<div id="min-length">
						<input type="text" id="minlength" class="form-control form-control-mobile input-md" name="min-length" placeholder="From" <?php if (isset($_GET['min-length']) and $_GET['min-length']) { echo 'value="' . $_GET['min-length'] . '"'; } ?>>
                        <?php echo Inventory_Helper::get_facet_deselector('min-length'); ?>
					</div>

				</div>

				<div class="length-input">

					<div id="max-length">
						<input type="text" id="maxlength" class="form-control form-control-mobile input-md" name="max-length" placeholder="To" <?php if (isset($_GET['max-length']) and $_GET['max-length']) { echo 'value="' . $_GET['max-length'] . '"'; } ?>>
                        <?php echo Inventory_Helper::get_facet_deselector('max-length'); ?>
					</div>

				</div>

			</div>

		</div>

		<!-- Mobile Header/Button -->

		<div class="hidden-lg hidden-md hidden-sm show-filter" id="show-year"><?php _e('Year', 'inventory-plugin'); ?></div>

		<!-- Mobile Year View -->

		<div class="hidden-lg hidden-md hidden-sm search-by filter" id="year-filter">

			<div class="">

				<div class=" year-input">

					<div id="min-year">

						<input type="text" id="minyear" class="form-control form-control-mobile input-md" name="min-year" placeholder="From" <?php if (isset($_GET['min-year']) and $_GET['min-year']) { echo 'value="' . $_GET['min-year'] . '"'; } ?>>
                        <?php echo Inventory_Helper::get_facet_deselector('min-year'); ?>
					</div>

				</div>

				<div class=" year-input">

					<div id="max-year">
						<input type="text" id="maxyear" class="form-control form-control-mobile input-md" name="max-year" placeholder="To" <?php if (isset($_GET['max-year']) and $_GET['max-year']) { echo 'value="' . $_GET['max-year'] . '"'; } ?>>
                        <?php echo Inventory_Helper::get_facet_deselector('max-year'); ?>
					</div>

				</div>

			</div>

		</div>

		<div class="search-btn">

			<button id="search-btn-mobile" type="button" class="col-xs-12 btn btn-primary search-btn-2"><?php _e('Update Results', 'inventory-plugin'); ?></button>

		</div>

	</div>

</div>

</form>
