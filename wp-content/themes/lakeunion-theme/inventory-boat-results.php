		<!-- START BOATS RESULTS -->

		<div class="col-sm-9 col-xs-12 col-md-8 col-lg-9" id="boat-list">



					<?php

						if ($post->inventory['all_result'] < 1 || empty($post->inventory['results'])){
								echo "<li style='line-height:20px'>" . __('Sorry, there are no boats in our database that match your search today, please try a different search.', 'inventory-plugin') . "</li>";
							} else {
							foreach ($post->inventory['results'] as $boat) {
							if (isset($_GET['currency']) and $_GET['currency']) {
								$currencylink = $_GET['currency'];
							} else {
								$currencylink = $post->inventory['currency'];
						}

					?>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 single-listing">


					<div class="lusr-boat-listing">

						<div class="inventory-model-single">



								<?php
								$firstimguri = "images/no-image.jpg";
								$firstimgcaption = "No Image Available";
								if (array_key_exists('Images', $boat)) {
									$images = $boat['Images'];
									if (!empty($images)) {
										$firstimguri = $images[0]['Uri'];
										$firstimguri = str_replace('.qa', '', $firstimguri);
										//$firstimguri = str_replace('LARGE', 'THUMBNAIL', $firstimguri);
										$firstimgcaption = $images[0]['Caption'];
									}
								}
								echo "<div class='boat-image'><img src=\"" . $firstimguri . "\" alt=\"" . $boat['MakeString'] . " " . $boat['Model'] . " " . $firstimgcaption . "\" / class=\"img-responsive\" ></div>";
								$caption = "";
								if (array_key_exists('MakeString', $boat)) {
									$caption = $caption . $boat['MakeString'] . " ";
								}
								if (array_key_exists('Model', $boat)) {
									$caption = $caption . $boat['Model'];
								}
								if (array_key_exists('LengthOverall', $boat) && !empty($boat['LengthOverall'])) {
									$caption = $caption . " | " . $boat['LengthOverall'];
								}
								if (array_key_exists('ModelYear', $boat)) {
									$caption = $caption . " | " . $boat['ModelYear'];
								}
								if (array_key_exists('GeneralBoatDescription', $boat)) {
									$caption = $caption . $boat['GeneralBoatDescription'][0] . " ";
								}

								$priceStr = Inventory_Helper::get_price_string($boat, $post->inventory['currencies']);

								if (array_key_exists('BoatLocation', $boat)) {
									$location = $boat['BoatLocation'];
									if (array_key_exists('BoatCountryID', $location)) {
										$country = $post->inventory['countries']->getCountryName($location['BoatCountryID']);
										if (array_key_exists('BoatCityName', $location) && $location['BoatCityName'] != 'Unknown') {
											$locationStr = $location['BoatCityName'] . ", $country";
										} else {
											$locationStr = $country;
										}
									} else if (array_key_exists('BoatCityName', $location)) {
										$locationStr = $location['BoatCityName'];
									}
								}



								?>

								<div class="boat-details">

									<div class="boat-make">

									<div class="row">

										<div class="col-lg-12">

											<h5><?php echo $boat['MakeString'] . ' <span>' . $boat['Model'] ?></span></h5>

										</div>

										</div>

									</div>

									<div class="middle-boat">

									<div class="row">

										<div class="col-lg-12">

											<?php
											$lgexcerptLen = 100;
											$mdexcerptLen = 80;
											$description = $boat['GeneralBoatDescription'][0];
											echo "<div class='hidden-md hidden-sm hidden-xs excerpt'>" . substr(strip_tags($description), 0, $lgexcerptLen) . "... </div>";
											echo "<div class='hidden-lg hidden-sm hidden-xs excerpt'>" . substr(strip_tags($description), 0, $mdexcerptLen) . "... </div>";
											?>

										</div>

										</div>

									</div>

									<hr />

									<div class="bottom-boat">
										<div class="row">
										<?php if (array_key_exists('ModelYear', $boat) && !empty($boat['ModelYear'])) : ?>
											<div class="col-xs-12 boat-year"><span><?php _e('Year:', 'inventory-plugin'); ?><br></span><?php echo $boat['ModelYear'] ?></div>
										<?php endif; ?>
										<div class="col-xs-12 boat-length">
										  <span><?php _e('Length:', 'inventory-plugin'); ?><br></span>
										  <?php if(Inventory_Helper::has_measurement_type('ft')) : ?>
										      <div class="length-ft"> <?php echo Inventory_Helper::get_length_string($boat, 'ft'); ?> </div>
										  <?php endif; ?>
										  <?php if(Inventory_Helper::has_measurement_type('m')) : ?>
										      <div class="length-mt"> (<?php echo Inventory_Helper::get_length_string($boat, 'm'); ?>) </div>
										  <?php endif; ?>
										</div>

										<div class="boat-location">

										<div class="col-lg-12">

											<span>Location:</span> <?php echo Inventory_Helper::get_location_string($boat) ?>

											</div>

										</div>

										<div class="col-xs-12 boat-price"><span>Priece:</span> <?php echo $priceStr ?></div>

									</div>

									</div>

								</div>

								<hr />

								<div class="lusr-view-more-btn">
							<a href="<?php echo Inventory_Helper::get_details_page_url($boat); ?>"> View Details </a>
							</div>

							</div>

						</div>


					</div>

					<?php
				} //end exclusion of test boats
			}//end foreach
			?>

			<!-- END BOAT RESULTS -->
