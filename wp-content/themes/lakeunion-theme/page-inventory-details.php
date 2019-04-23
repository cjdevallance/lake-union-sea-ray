<?php
/**
 * Template Name: Inventory Details Page
* Display boat details page
*/
the_post();

get_header('sub');

$categories = !empty($post->inventory['boat']['BoatClassCode']) ? implode(', ', $post->inventory['boat']['BoatClassCode']) : '-';
$title = $post->inventory['boat']['ModelYear'] . ' ' . $post->inventory['boat']['MakeString'] . ' ' . $post->inventory['boat']['Model'];

?>

<div class="container">

<div class="row">

    <!-- MAIN CONTENT -->
    <div class="col-md-9 col-xs-12 boat-details">

		<div class="row manufacturer-title-area">

			<div class="col-sm-8">

				<h1><?php the_title(); ?></h1>

				<div class="details-location">

					<?php echo Inventory_Helper::get_location_string($post->inventory['boat']); ?>

				</div>

			</div>

			<div class="col-md-4 inv-price-title">

				<?php if(!empty($post->inventory['boat']['Price'])) : ?>

					<h1 class="pull-right"><?php echo Inventory_Helper::get_price_string($post->inventory['boat']); ?></h1>

				<?php endif; ?>

			</div>

		</div>

		<?php if(!empty($post->inventory['boat']['Images'])) : ?>

			<div class="row">

							<div class="col-lg-12">

								<div class="bxslider" id="">

									<?php if(!empty($post->inventory['boat']['Images']) && count($post->inventory['boat']['Images']) > 1)  : ?>
									<!-- hero image -->
									<?php $post->inventory['boat']['Images'][0]['Uri'] = str_replace("LARGE", "XLARGE", $post->inventory['boat']['Images'][0]['Uri']); ?>
									<img src="<?php echo $post->inventory['boat']['Images'][0]['Uri']; ?>">

									<?php if(!empty($post->inventory['boat']['Videos']) && !empty($post->inventory['boat']['Videos']['url'])) : ?>
									<?php for($i=0; $i < count($post->inventory['boat']['Videos']['url']); $i++) : ?>
									<!--<a href="<?php echo $post->inventory['boat']['Videos']['url'][$i] ?>">
									<img src="<?php echo $post->inventory['boat']['Videos']['thumbnailUrl'][$i] ?>" />
									</a>-->
									<?php endfor;?>
									<?php endif; ?>

									<?php for($i=1; $i<count($post->inventory['boat']['Images']); $i++) : ?>
									<img src="<?php echo $post->inventory['boat']['Images'][$i]['Uri']; ?>">
									<?php endfor; ?>
									<?php endif; ?>
								</div>

							</div>

							<div class="col-lg-12">
								
								<div id="bx-pager">

										<?php $int = 1; ?>

								<?php for($i=1; $i<count($post->inventory['boat']['Images']); $i++) : ?>

									<a data-slide-index="<?php echo $int++; ?>" href="">

			                        <img src="<?php echo $post->inventory['boat']['Images'][$i]['Uri']; ?>">

			                        </a>

			                    <?php endfor; ?>

			                    </div>

							</div>

							
			</div>

		<?php endif; ?>

		<hr/>

        <ul class="nav nav-tabs" id="new-boat-tabs">

            <li class="active">

                <a href="#description" aria-controls="description" role="tab" data-toggle="tab">

                    <h3 class="tabs"><?php _e('Description', 'theme-essential-elite'); ?></h3>

                </a>

            </li>

            <?php if(!empty($post->inventory['boat']['AdditionalDetailDescription'])) : ?>

                <li>

                    <a href="#specification" aria-controls="specification" role="tab" data-toggle="tab">

                        <h3 class="tabs"><?php _e('Specification', 'theme-essential-elite'); ?></h3>

                    </a>

                </li>

            <?php endif; ?>

        </ul>

		<div id='content' class="tab-content">

		<div class="tab-pane active" id="description">

		<div class="specs">

		<div class="row spec-row">

		<?php if(Mmp_Api_Boat_Helper::has_boat_category('dimensions', $post->inventory['boat'])) : ?>

		<div class="col-sm-6 col-xs-12">

		<h4><?php _e('Builder', 'theme-essential-elite'); ?> / <?php _e('Designer', 'theme-essential-elite'); ?></h4>

		<?php if(!empty($post->inventory['boat']['ModelYear'])) : ?>

		<div><span><?php _e('Year', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['ModelYear']; ?> </div>

		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['BuilderName'])) : ?>
		<div><span><?php _e('Builder', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['BuilderName']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['DesignerName'])) : ?>
		<div><span><?php _e('Designer', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['DesignerName']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['BoatHullMaterialCode'])) : ?>
		<div><span><?php _e('Construction', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['BoatHullMaterialCode']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['BoatKeelCode'])) : ?>
		<div><span><?php _e('Boat Keel', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['BoatKeelCode']; ?> </div>
		<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php if(Mmp_Api_Boat_Helper::has_boat_category('engines', $post->inventory['boat'])) : ?>
		<div class="col-sm-6 col-xs-12">
		<h4><?php _e('Engines', 'theme-essential-elite'); ?> / <?php _e('Speed', 'theme-essential-elite'); ?></h4>

		<?php if(!empty($post->inventory['boat']['NumberOfEngines'])) : ?>
		<div><span><?php _e('Engines', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['NumberOfEngines']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['Engines'][0]['Type'])) : ?>
		<div><span><?php _e('Engine Type', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['Engines'][0]['Type']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['TotalEnginePowerQuantity'])) : ?>
		<div><span><?php _e('Engine Power', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['TotalEnginePowerQuantity']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['CruisingSpeedMeasure'])) : ?>
		<div><span><?php _e('Cruising Speed', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['CruisingSpeedMeasure']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['PropellerCruisingSpeed'])) : ?>
		<div><span><?php _e('Propeller Cruising Speed', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['PropellerCruisingSpeed']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['MaximumSpeedMeasure'])) : ?>
		<div><span><?php _e('Maximum Speed', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['MaximumSpeedMeasure']; ?> </div>
		<?php endif; ?>
		</div>
		<?php endif; ?>
		</div>

		<div class="row spec-row">

		<?php if(Mmp_Api_Boat_Helper::has_boat_category('dimensions', $post->inventory['boat'])) : ?>
		<div class="col-sm-6 col-xs-12">
		<h4><?php _e('Dimensions', 'theme-essential-elite'); ?></h4>
		<?php if(!empty($post->inventory['boat']['NominalLength'])) : ?>
		<div>
		<span><?php _e('Nominal Length', 'theme-essential-elite'); ?>:</span>
		<?php echo Inventory_Helper::get_length_string_both_units($post->inventory['boat'], 'NominalLength'); ?>
		</div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['LengthOverall'])) : ?>
		<div>
		<span><?php _e('Length Overall', 'theme-essential-elite'); ?>:</span>
		<?php echo Inventory_Helper::get_length_string_both_units($post->inventory['boat'], 'LengthOverall'); ?>
		</div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['BeamMeasure'])) : ?>
		<div>
		<span><?php _e('Beam', 'theme-essential-elite'); ?>:</span>
		<?php echo Inventory_Helper::get_length_string_both_units($post->inventory['boat'], 'BeamMeasure'); ?>
		</div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['MaximumSpeedMeasure'])) : ?>
		<div><span><?php _e('Maximum Speed', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['MaximumSpeedMeasure']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['MaxDraft'])) : ?>
		<div>
		<span><?php _e('Max Draft', 'theme-essential-elite'); ?>:</span>
		<?php echo Inventory_Helper::get_length_string_both_units($post->inventory['boat'], 'MaxDraft'); ?>
		</div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['DriveUp'])) : ?>
		<div>
		<span><?php _e('Drive Up', 'theme-essential-elite'); ?>:</span>
		<?php echo Inventory_Helper::get_length_string_both_units($post->inventory['boat'], 'DriveUp'); ?>
		</div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['DisplacementMeasure'])) : ?>
		<div><span><?php _e('Displacement', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['DisplacementMeasure']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['BallastWeightMeasure'])) : ?>
		<div><span><?php _e('Ballast', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['BallastWeightMeasure']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['BridgeClearanceMeasure'])) : ?>
		<div>
		<span><?php _e('Bridge Clearance', 'theme-essential-elite'); ?>:</span>
		<?php echo Inventory_Helper::get_length_string_both_units($post->inventory['boat'], 'BridgeClearanceMeasure'); ?>
		</div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['FreeBoardMeasure'])) : ?>
		<div>
		<span><?php _e('Free Board', 'theme-essential-elite'); ?>:</span>
		<?php echo Inventory_Helper::get_length_string_both_units($post->inventory['boat'], 'FreeBoardMeasure'); ?>
		</div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['CabinHeadroomMeasure'])) : ?>
		<div>
		<span><?php _e('Cabin Headroom', 'theme-essential-elite'); ?>:</span>
		<?php echo Inventory_Helper::get_length_string_both_units($post->inventory['boat'], 'CabinHeadroomMeasure'); ?>
		</div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['DryWeightMeasure'])) : ?>
		<div><span><?php _e('Dry Weight', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['DryWeightMeasure']; ?> </div>
		<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php if(Mmp_Api_Boat_Helper::has_boat_category('tanks', $post->inventory['boat'])) : ?>
		<div class="col-sm-6 col-xs-12">
		<h4><?php _e('Tanks', 'theme-essential-elite'); ?></h4>

		<?php if(!empty($post->inventory['boat']['FuelTankCountNumeric'])) : ?>
		<div><span><?php _e('Fuel Tanks', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['FuelTankCountNumeric']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['FuelTankCapacityMeasure'])) : ?>
		<div><span><?php _e('Fuel Tank Capacity', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['FuelTankCapacityMeasure']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['WaterTankCountNumeric'])) : ?>
		<div><span><?php _e('Water Tanks', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['WaterTankCountNumeric']; ?> </div>
		<?php endif; ?>

		<?php if(!empty($post->inventory['boat']['WaterTankCapacityMeasure'])) : ?>
		<div><span><?php _e('Water Tank Capacity', 'theme-essential-elite'); ?>:</span> <?php echo $post->inventory['boat']['WaterTankCapacityMeasure']; ?> </div>
		<?php endif; ?>
		</div>
		<?php endif; ?>

		</div>

		</div>

		<div class="pdf-download">

                <a target="_blank" href="?pdf=1" type="button" class="btn btn-primary btn-block">

                    <?php _e('Download PDF', 'theme-essential-elite'); ?>

                    <span class="glyphicon glyphicon-download" aria-hidden="true"></span>

                </a>

            </div>

		<br />

		<?php if(!empty($post->inventory['boat']['GeneralBoatDescription'])) : ?>

		<div class="description row">

		<?php foreach($post->inventory['boat']['GeneralBoatDescription'] as $desc) : ?>

		<div class="col-lg-12"><?php echo $desc ?></div>

		<?php endforeach; ?>

		</div>

		<?php endif; ?>

		</div>

		<?php if(!empty($post->inventory['boat']['AdditionalDetailDescription'])) : ?>

		<div class="tab-pane" id="specification">

		<div class="row">

		<?php foreach($post->inventory['boat']['AdditionalDetailDescription'] as $desc) : ?>

		<div class="col-lg-12"><?php echo $desc ?></div>

		<?php endforeach; ?>

		</div>

		</div>

		<?php endif; ?>

		</div>

    </div>
    <!-- MAIN CONTENT END -->
    <!-- SIDEBAR CONTENT -->


		<?php get_sidebar() ?>

		<!-- SIDEBAR CONTENT END -->

		</div>

</div>
</div>
<br />
<?php get_footer(); ?>
