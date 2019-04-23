<?php 
$selected_country   = Inventory_Helper::get_search_permalink_params('country');
$selected_state     = Inventory_Helper::get_search_permalink_params('state');
$selected_city      = Inventory_Helper::get_search_permalink_params('city');
$selected_condition = Inventory_Helper::get_search_permalink_params('condition');
$selected_category  = Inventory_Helper::get_search_permalink_params('category');
$selected_make      = Inventory_Helper::get_search_permalink_params('make');
$selected_model     = Inventory_Helper::get_search_permalink_params('model');

$countries_shown = false;
$states_shown = false;
$cities_shown = false;
?>

<div class="col-xs-12 secondary-search">


	<h4><?php _e('Filter By', 'inventory-plugin'); ?></h4>

	<!-- Desktop Header -->
	<div class="hidden-xs"><h5><?php _e('Type', 'inventory-plugin'); ?></h5></div>

	<!-- Mobile Header/Button -->
	<div class="hidden-lg hidden-md hidden-sm col-xs-12 show-filter" id="show-type"><?php _e('Type', 'inventory-plugin'); ?></div>

	<!-- Desktop Type View -->
	<div class="col-sm-12 hidden-xs filter">
		<?php
		if ( isset($post->inventory['category_array']) and $post->inventory['category_array'] ) {
			arsort( $post->inventory['category_array'] );
			foreach ($post->inventory['category_array'] as $category => $number) {
				if (isset($selected_category) && $category == $selected_category) { ?>
					<div class="col-xs-12 indfilter">
						<a class="selected-category-link selected link" name="category-links" id="category-links"
						  href="<?php echo Inventory_Helper::generate_search_url(array('category' => '', true)); ?>"><?php echo $category; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-xs-12 indfilter">
						<a class="category-link link" name="category-links" id="category-links" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('category' => $category)); ?>"><?php echo $category; ?></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
		} else {
			echo  __( 'No Boats Available' , 'inventory-plugin' );
		}

		?>

	</div>

	<!-- Mobile Type View  -->
	<div class="filter" id="type-filter">
		<?php
		if ( isset($post->inventory['category_array']) and $post->inventory['category_array'] ) {
			arsort( $post->inventory['category_array'] );
			foreach ($post->inventory['category_array'] as $category => $number) {
				if (isset($selected_category) && $category == $selected_category) { ?>
					<div class="col-xs-12 indfilter">
						<a class="selected-category-link selected link" name="category-links" id="category-links" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('category' => '')) ?>"><?php echo $category; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-xs-12 indfilter">
						<a class="category-link link" name="category-links" id="category-links"
						  href="<?php echo Inventory_Helper::generate_search_url(array('category' => $category)); ?>"><?php echo $category; ?></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
		} else {
			echo  __( 'No Boats Available' , 'inventory-plugin' );
		}

		?>

	</div>

	<!-- Desktop Header -->
	<div class="hidden-xs"><h5><?php _e('Condition', 'inventory-plugin'); ?></h5></div>

	<!-- Mobile Header/Button -->
	<div class="hidden-lg hidden-md hidden-sm col-xs-12 show-filter" id="show-condition"><?php _e('Condition', 'inventory-plugin'); ?></div>

	<!-- Desktop Condition View -->
	<div class="col-sm-12 hidden-xs filter">
		<?php
		if ( $post->inventory['condition_array'] ) {
			arsort( $post->inventory['condition_array'] );
			foreach ($post->inventory['condition_array'] as $conditon => $number) {
				if (isset($selected_condition) and $conditon == $selected_condition) { ?>
					<div class="col-xs-12 indfilter">
						<a class="selected-condition-link selected link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('condition' => ''))?>">
						    <?php echo $conditon; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-xs-12 indfilter">
						<a class="condition-link link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('condition' => $conditon))?>">
						    <?php echo $conditon; ?></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
		} else {
			echo  __( 'No Boats Available' , 'inventory-plugin' );
		}

		?>

	</div>

	<!-- Mobile Condition View -->
	<div class="filter hidden-sm hidden-md hidden-lg" id="condition-filter">
		<?php
		if ( $post->inventory['condition_array'] ) {
			arsort( $post->inventory['condition_array'] );
			foreach ($post->inventory['condition_array'] as $conditon => $number) {
				if (isset($selected_condition) and $conditon == $selected_condition) { ?>
					<div class="col-xs-12 indfilter">
						<a class="selected-condition-link selected link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('condition' => ''))?>">
						  <?php echo $conditon; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-xs-12 indfilter">
						<a class="condition-link link"
						  href="<?php echo Inventory_Helper::generate_search_url(array('condition' => $conditon))?>"><?php echo $conditon; ?></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
		} else {
			echo  __( 'No Boats Available' , 'inventory-plugin' );
		}

		?>

	</div>

	<!-- Desktop Header -->
	<div class="hidden-xs"><h5><?php _e('Make', 'inventory-plugin'); ?></h5></div>

	<!-- Mobile Header/Button -->
	<div class="hidden-lg hidden-md hidden-sm col-xs-12 show-filter" id="show-make"><?php _e('Make', 'inventory-plugin'); ?></div>

	<!-- Desktop Make View -->
	<div class="col-sm-12 hidden-xs filter">
		<?php
		if ( $post->inventory['manufacturer_array'] ) {
			arsort( $post->inventory['manufacturer_array'] );
			$manufacturer_array_sliced = array_slice($post->inventory['manufacturer_array'], 0, 10, true);
			foreach ($manufacturer_array_sliced as $make => $number) {
				if (isset($selected_make) and $make == $selected_make) { ?>
					<div class="col-xs-12 indfilter">
						<a class="selected-make-link selected link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('make' => '', 'model' => '')); ?>"><?php echo $make; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-xs-12 indfilter">
						<a class="make-link link" href="<?php echo Inventory_Helper::generate_search_url(array('make' => $make)); ?>"><?php echo $make; ?></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
			if (count($post->inventory['manufacturer_array']) > 10) { ?>
				<div class="col-xs-12 indfilter">
					<a class="more-makes link" id="go" rel="leanModal" name="manufacturer-full" href="#manufacturer-full"><?php _e('More', 'inventory-plugin'); ?>...</a>
				</div>
			<?php }
		} else {
			echo  __( 'No Boats Available' , 'inventory-plugin' );
		}

		?>

	</div>

	<!-- Mobile Make View -->
	<div class="filter" id="make-filter">
		<?php
		if ( $post->inventory['manufacturer_array'] ) {
			arsort( $post->inventory['manufacturer_array'] );
			foreach ($post->inventory['manufacturer_array'] as $make => $number) {
				if (isset($selected_make) and $make == $selected_make) { ?>
					<div class="col-xs-12 indfilter">
						<a class="selected-make-link selected link"
						  href="<?php echo Inventory_Helper::generate_search_url(array('make' => '', 'model' => '')); ?>"><?php echo $make; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-xs-12 indfilter">
						<a class="make-link link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('make' => $make)); ?>"><?php echo $make; ?></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
		} else {
			echo  __( 'No Boats Available' , 'inventory-plugin' );
		}

		?>

	</div>

	<!-- MORE MANUFACTURERS POPUP -->

	<div id="manufacturer-full" class="col-xs-8">
		<div class="modal_close glyphicon glyphicon-remove"></div>
		<?php
		ksort( $post->inventory['manufacturer_array'] );
		foreach ($post->inventory['manufacturer_array'] as $make => $number) {
			if (isset($selected_make) and $make == $selected_make) { ?>
				<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
					<a class="selected-make-link selected link"
					  href="<?php echo Inventory_Helper::generate_search_url(array('make' => '', 'model' => '')); ?>"><?php echo $make; ?> X</a>
				</div>
			<?php } else { ?>
				<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
					<a class="make-link link"
					  href="<?php echo Inventory_Helper::generate_search_url(array('make' => $make)); ?>"><?php echo $make; ?></a>
					<div class="filter-no">(<?php echo $number ?>)</div>
				</div>
			<?php }
		}
		?>

	</div>

	<!-- END MORE MANUFACTURERS POPUP -->

	<?php if (isset($selected_make) && !empty($selected_make)) { ?>

		<!-- Desktop Header -->
		<div class="hidden-xs"><h5><?php _e('Model', 'inventory-plugin'); ?></h5></div>

		<!-- Mobile Header/Button -->
		<div class="hidden-lg hidden-md hidden-sm col-xs-12 show-filter" id="show-model">Model</div>

		<!-- Desktop Model View -->

		<div class="col-sm-12 hidden-xs filter">

			<?php
			if ( $post->inventory['model_array'] ) {
				arsort( $post->inventory['model_array'] );
				$model_array_sliced = array_slice($post->inventory['model_array'], 0, 10, true);

				foreach ($model_array_sliced as $model => $number) {
					if (isset($selected_model) && $model == $selected_model) { ?>

						<div class="col-xs-12 indfilter">
							<a class="selected-model-link selected link" 
							  href="<?php echo Inventory_Helper::generate_search_url(array('model' => '')) ?>"><?php echo $model; ?> X</a>
						</div>
					<?php } else { ?>
						<div class="col-xs-12 indfilter">
							<a class="model-link link" 
							  href="<?php echo Inventory_Helper::generate_search_url(array('model' => $model)) ?>"><?php echo $model; ?></a>
							<div class="filter-no">(<?php echo $number ?>)</div>
						</div>
					<?php }
				}
				if (isset($post->inventory['model_array']) && count($post->inventory['model_array']) > 10) { ?>
					<div class="col-xs-12 indfilter">
						<a class="more-models link" id="go" rel="leanModal" name="model-full" href="#model-full"><?php _e('More', 'inventory-plugin'); ?>...</a>
					</div>
				<?php }
			} else {
				echo  __( 'No Boats Available' , 'inventory-plugin' );
			}

			?>

		</div>

		<!-- Mobile Model View -->

		<div class="filter" id="model-filter">

			<?php

			if ( $post->inventory['model_array'] ) {
				arsort( $post->inventory['model_array'] );
				foreach ($post->inventory['model_array'] as $model => $number) {
					if (isset($selected_model) and $model == $selected_model) { ?>

						<div class="col-xs-12 indfilter">
							<a class="selected-model-link selected link" 
							  href="<?php echo Inventory_Helper::generate_search_url(array('model' => '')) ?>">
							    <?php echo $model; ?> X</a>
						</div>
					<?php } else { ?>
						<div class="col-xs-12 indfilter">
							<a class="model-link link" 
							  href="<?php echo Inventory_Helper::generate_search_url(array('model' => $model)) ?>">
							    <?php echo $model; ?></a>
							<div class="filter-no">(<?php echo $number ?>)</div>
						</div>
					<?php }
				}
			} else {
				echo  __( 'No Boats Available' , 'inventory-plugin' );
			}

			?>

		</div>

		<!-- MORE Models POPUP -->

		<div id="model-full" class="col-xs-8">
			<div class="modal_close glyphicon glyphicon-remove"></div>
			<?php
			ksort( $post->inventory['model_array'] );
			foreach ($post->inventory['model_array'] as $modal => $number) {
				if (isset($selected_model) and $model == $selected_model) { ?>
					<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
						<a class="selected-model-link selected link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('model' => '')) ?>"><?php echo $model; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
						<a class="model-link link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('model' => $model)) ?>"><?php echo $model; ?></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
			?>

		</div>

		<!-- END MORE Models POPUP -->

	<?php } ?>

	
	<!-- Desktop Header -->
	<div class="hidden-xs"><h5><?php _e('Location', 'inventory-plugin'); ?></h5></div>

	<!-- Mobile Header/Button -->
	<div class="hidden-lg hidden-md hidden-sm col-xs-12 show-filter" id="show-location"><?php _e('Location', 'inventory-plugin'); ?></div>

	<!-- Desktop Location View -->
	<div class="col-sm-12 hidden-xs filter">
	    <!-- Location Countries -->
		<?php
		if (empty($selected_country)) :
			if ($post->inventory['location_country_array']) {
			    $countries_shown = true;
				arsort($post->inventory['location_country_array']);
				$location_country_array_sliced = array_slice($post->inventory['location_country_array'], 0, 10, true);
				foreach ($location_country_array_sliced as $location_country => $number) {
					if (isset($location_country) && $location_country != "") {
						$country = $post->inventory['countries']->getCountryName($location_country);
					} else {
						$country = __('Unknown Country', 'inventory-plugin');
					}
				    ?>
					<div class="col-xs-12 indfilter">
						<a class="locationcountry-link link" 
						   href="<?php echo Inventory_Helper::generate_search_url(array('country' => $location_country)) ?>">
						     <?php echo $country; ?><div style="display: none"><?php echo $location_country; ?></div></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>

				    <?php 
				}
				if (count($post->inventory['location_country_array']) > 10) { ?>
					<div class="col-xs-12 indfilter">
						<a class="more-location-countries link" id="go" rel="leanModal" name="location-country-full" href="#location-country-full">More...</a>
					</div>
				<?php }
			} else {
				echo __('No Boats Available', 'inventory-plugin');
			}
		?>
		<?php else : ?>
		<div class="col-xs-12 indfilter">
			<a class="selected-locationcountry-link selected link"
			  href="<?php echo Inventory_Helper::generate_search_url(array('country' => '', 'state' => '', 'city' => '')); ?>"><?php echo $post->inventory['countries']->getCountryName($selected_country); ?> X</a>
		</div>
		<?php endif; ?>
		<!-- END Location Countries -->

		<!-- MORE Location Countries POPUP -->
		<div id="location-country-full" class="col-xs-8">
			<div class="modal_close glyphicon glyphicon-remove"></div>
			<?php
			ksort( $post->inventory['location_country_array'] );
			foreach ($post->inventory['location_country_array'] as $location_country => $number) {
				if (isset($location_country) && $location_country != "") {
					$country = $post->inventory['countries']->getCountryName($location_country);
				} else {
					$country = __('Unknown Country', 'inventory-plugin');
				}
				if (isset($selected_country) && $location_country == $selected_country) { ?>
					<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
						<a class="selected-locationcountry-link selected link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('country' => '', 'state' => '', 'city' => '')) ?>"><?php echo $country; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
						<a class="locationcountry-link link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('country' => $location_country)) ?>"><?php echo $country; ?><div style="display: none"><?php echo $location_country; ?></div></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
			?>

		</div>
        <!-- END MORE Location Countries POPUP -->

	    <!-- Location States -->
		<?php
		if ( !empty($selected_country) && empty($selected_state)) :  
			if ($post->inventory['location_state_array']) :
			    $states_shown = true;
				arsort($post->inventory['location_state_array']);
				$location_state_array_sliced = array_slice($post->inventory['location_state_array'], 0, 10, true);
				foreach ($location_state_array_sliced as $location_state => $number) :

					if(empty($location_state)) continue;

					$state = $post->inventory['states']->getStateName($location_state);
					?>
					<div class="col-xs-12 indfilter">
						<a class="locationstate-link link" 
						     href="<?php echo Inventory_Helper::generate_search_url(array('country' => $post->inventory['states']->getCountryByState($location_state), 'state' => $location_state)) ?>"><?php echo $state; ?><div style="display: none"><?php echo $location_state; ?></div></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
					<?php
				endforeach;

				if (count($post->inventory['location_state_array']) > 10) : ?>
					<div class="col-xs-12 indfilter">
						<a class="more-location-states link" id="go" rel="leanModal" name="location-state-full" href="#location-state-full"><?php _e('More', 'inventory-plugin') ?>...</a>
					</div>
				<?php 
				endif;
			endif; 
	    ?> 
		<?php elseif(!empty($selected_state)) : ?>
		<div class="col-xs-12 indfilter">
			<a class="selected-locationstate-link selected link"
			  href="<?php echo Inventory_Helper::generate_search_url(array('state' => '', 'city' => '')) ?>">
			  <?php echo $post->inventory['states']->getStateName($selected_state); ?> X
			</a>
		</div>		
		<?php endif; ?>
		<!-- END Location States -->

		<!-- MORE Location States POPUP -->
		<div id="location-state-full" class="col-xs-8">
			<div class="modal_close glyphicon glyphicon-remove"></div>
			<?php
			ksort( $post->inventory['location_state_array'] );
			foreach ($post->inventory['location_state_array'] as $location_state => $number) {
				if(empty($location_state)) {
					continue;
				}

				$state = $post->inventory['states']->getStateName($location_state);

				if (isset($selected_state) and $location_state == $selected_state) { ?>
					<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
						<a class="selected-locationstate-link selected link"
						  href="<?php echo Inventory_Helper::generate_search_url(array('state' => '', 'city' => '')) ?>"><?php echo $state; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
						<a class="locationstate-link link"
						  href="<?php echo Inventory_Helper::generate_search_url(array('country' => $post->inventory['states']->getCountryByState($location_state), 'state' => $location_state)) ?>">
						    <?php echo $state; ?><div style="display: none"><?php echo $location_state; ?></div></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
			?>
		</div>
		<!-- END MORE Location States POPUP -->
		
		<!-- Location City -->	
		<?php
		if ( !$countries_shown && !$states_shown && empty($selected_city) ) :

			if ($post->inventory['location_city_array']) :
				arsort($post->inventory['location_city_array']);
		        $cities_shown = true;
				$location_city_array_sliced = array_slice($post->inventory['location_city_array'], 0, 10, true);
				foreach ($location_city_array_sliced as $location_city => $number) :
				?>
				<div class="col-xs-12 indfilter">
					<a class="locationcity-link link" 
					  href="<?php echo Inventory_Helper::generate_search_url(array('city' => $location_city, 'state' => $selected_state, 'country' => $selected_country)); ?>"><?php echo $location_city; ?></a>
					<div class="filter-no">(<?php echo $number ?>)</div>
				</div>
				<?php 
				endforeach;
				if (count($post->inventory['location_city_array']) > 10) : ?>
					<div class="col-xs-12 indfilter">
						<a class="more-location-cities link" id="go" rel="leanModal" name="location-city-full" href="#location-city-full"><?php _e('More', 'inventory-plugin'); ?>...</a>
					</div>
				<?php 
				endif;
			endif;

		elseif(!empty($selected_city)) :
		?>	
		<div class="col-xs-12 indfilter">
			<a class="selected-locationcity-link selected link"
			  href="<?php echo Inventory_Helper::generate_search_url(array('city' => ''))?>">
			    <?php echo $selected_city; ?> X</a>
		</div>		
		<?php endif; ?>
		<!-- END Location City -->		

		<!-- MORE Location Cities POPUP -->
		<div id="location-city-full" class="col-xs-8">
			<div class="modal_close glyphicon glyphicon-remove"></div>
			<?php
			ksort( $post->inventory['location_city_array'] );
			foreach ($post->inventory['location_city_array'] as $location_city => $number) {
				if (isset($selected_city) && $location_city == $selected_city) { ?>
					<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
						<a class="selected-locationcity-link selected link"
						  href="<?php echo Inventory_Helper::generate_search_url(array('city' => ''))?>"><?php echo $location_city; ?> X</a>
					</div>
				<?php } else { ?>
					<div class="col-lg-2 col-sm-3 col-xs-12 indfilter">
						<a class="locationcity-link link" 
						  href="<?php echo Inventory_Helper::generate_search_url(array('city' => $location_city, 'state' => $selected_state, 'country' => $selected_country)); ?>"><?php echo $location_city; ?></a>
						<div class="filter-no">(<?php echo $number ?>)</div>
					</div>
				<?php }
			}
			?>

		</div>
		<!-- END MORE Location Cities POPUP -->

	</div>

	<!-- Mobile Location View -->
	<div class="filter" id="location-filter">
	    <?php 
        // Countries
		if (empty($selected_country)) :
			if ($post->inventory['location_country_array']) :
			    $countries_shown = true;
				arsort($post->inventory['location_country_array']);
				foreach ($post->inventory['location_country_array'] as $location_country => $number) :
					if (isset($location_country) && $location_country != "") :
						$country = $post->inventory['countries']->getCountryName($location_country);
					else:
						$country = __('Unknown Country', 'inventory-plugin');
					endif;
					?>
						<div class="col-xs-12 indfilter">
							<a class="locationcountry-link link" 
							  href="<?php echo Inventory_Helper::generate_search_url(array('country' => $location_country)) ?>">
							  <?php echo $country; ?></a>
							<div class="filter-no">(<?php echo $number ?>)</div>
						</div>
					<?php 
				endforeach;
			endif;
        else : ?>
			<div class="col-xs-12 indfilter">
				<a class="selected-locationcountry-link selected link"
				  href="<?php echo Inventory_Helper::generate_search_url(array('country' => '', 'state' => '', 'city' => '')); ?>">
				    <?php echo $post->inventory['countries']->getCountryName($selected_country); ?> X
				</a>
			</div>  		      
        <?php 
		endif; 	


		// States
		if (!empty($selected_country) && empty($selected_state)) {
        
			if ($post->inventory['location_state_array']) {
				arsort($post->inventory['location_state_array']);
				$states_shown = true;
				foreach ($post->inventory['location_state_array'] as $location_state => $number) {
					if(empty($location_state)) {
						continue;
					}

					$state = $post->inventory['states']->getStateName($location_state);

					if (isset($selected_state) and $location_state == $selected_state) { ?>
						<div class="col-xs-12 indfilter">
							<a class="selected-locationstate-link selected link"
							  href="<?php echo Inventory_Helper::generate_search_url(array('state' => '', 'city' => '')) ?>"><?php echo $state; ?> X</a>
						</div>
					<?php } else { ?>
						<div class="col-xs-12 indfilter">
							<a class="locationstate-link link"
							  href="<?php echo Inventory_Helper::generate_search_url(array('country' => $post->inventory['states']->getCountryByState($location_state), 'state' => $location_state)) ?>">
							    <?php echo $state; ?><div style="display: none"><?php echo $location_state; ?></div></a>
							<div class="filter-no">(<?php echo $number ?>)</div>
						</div>
					<?php }
				}
			} 
		}
		elseif(!empty($selected_state)) { ?>
				<div class="col-xs-12 indfilter">
					<a class="selected-locationstate-link selected link"
					  href="<?php echo Inventory_Helper::generate_search_url(array('state' => '', 'city' => '')) ?>">
					  <?php echo $post->inventory['states']->getStateName($selected_state); ?> X
					</a>
				</div>		
		<?php 
		}

		// Cities
		if ( !$countries_shown && !$states_shown && empty($selected_city) ) :

			if ($post->inventory['location_city_array']) :
			    $cities_shown = true;
				arsort($post->inventory['location_city_array']);
				foreach ($post->inventory['location_city_array'] as $location_city => $number) : ?>
						<div class="col-xs-12 indfilter">
							<a class="locationcity-link link" 
							  href="<?php echo Inventory_Helper::generate_search_url(array('city' => $location_city, 'state' => $selected_state, 'country' => $selected_country)); ?>">
							    <?php echo $location_city; ?></a>
							<div class="filter-no">(<?php echo $number ?>)</div>
						</div>
						<?php
				endforeach;
			endif; 
	    elseif(!empty($selected_city)) : ?>
    		<div class="col-xs-12 indfilter">
    			<a class="selected-locationcity-link selected link"
    			  href="<?php echo Inventory_Helper::generate_search_url(array('city' => '')) ?>"><?php echo $selected_city; ?> X</a>
    		</div>	    
	    <?php 
		endif;
		?>
		
		<?php 
		if( ( !$countries_shown && empty($selected_country) ) && 
		    ( !$states_shown && empty($selected_state) ) && 
		    ( !$cities_shown && empty($selected_city)) )
		    echo __('No Boats Available', 'inventory-plugin');

		?>

	</div>

</div>