<?php

the_post();
$boat = $post->boat;
$categories = !empty($boat['BoatClassCode']) ? implode(', ', $boat['BoatClassCode']) : '-';
$title = $boat['ModelYear'] . ' ' . $boat['MakeString'] . ' ' . $boat['Model'];
?>

</div>

<div class="row manufacturer-title-area">

    <div class="container">

        <div class="col-md-8">
            <h1><?php echo $title ?></h1>
        </div>
        <div class="col-md-4">
            <div class="brand-logo"><?php echo $boat['logo'] ?></div>
        </div>

    </div>

</div>

<div class="container">

<div class="row">
    
    <!-- MAIN CONTENT -->
    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 boat-details">
        <?php if(!empty($boat['Images'])) : ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="galleria" id="galleria">
                    <?php if(!empty($boat['Images']) && count($boat['Images']) > 1)  : ?>
                        <!-- hero image -->
                        <?php $boat['Images'][0]['Uri'] = str_replace("LARGE", "XLARGE", $boat['Images'][0]['Uri']); ?>
                        <img src="<?php echo $boat['Images'][0]['Uri']; ?>"> 
                        
                        <?php if(!empty($boat['Videos']) && !empty($boat['Videos']['url'])) : ?>
                        <?php for($i=0; $i < count($boat['Videos']['url']); $i++) : ?>
                            <!--<a href="<?php echo $boat['Videos']['url'][$i] ?>">
                                <img src="<?php echo $boat['Videos']['thumbnailUrl'][$i] ?>" />
                            </a>-->
                        <?php endfor;?>
                        <?php endif; ?>
                        
                        <?php for($i=1; $i<count($boat['Images']); $i++) : ?>
                        <img src="<?php echo $boat['Images'][$i]['Uri']; ?>"> 
                        <?php endfor; ?>
                    <?php endif; ?>  
                    </div>
                    
                    <script>
                        Galleria.loadTheme('<?php echo esc_url(get_template_directory_uri()); ?>/galleria/themes/classic/galleria.classic.min.js');
        				Galleria.configure({
        				    transition: 'fade',
        				    imageCrop: true,
        				    idleMode: 'hover'
        				});
                        Galleria.run('#galleria');
                    </script>                   
                   
                </div>
            </div>
        <?php endif; ?>

        <ul class="nav nav-tabs" id="new-boat-tabs">
            <li class="active">
                <a href="#description" aria-controls="description" role="tab" data-toggle="tab">
                    <h3><?php _e('Description', 'theme-essential-elite'); ?></h3>
                </a>
            </li>
            <?php if(!empty($boat['AdditionalDetailDescription'])) : ?>
                <li data-toggle="tab">
                    <a href="#specification" aria-controls="specification" role="tab" data-toggle="tab">
                        <h3><?php _e('Specification', 'theme-essential-elite'); ?></h3>
                    </a>
                </li>
            <?php endif; ?>
            <div class="pdf-download">
                <a target="_blank" href="?pdf=1" type="button" class="btn btn-primary btn-block">
                    <?php _e('Download PDF', 'theme-essential-elite'); ?>
                    <span class="glyphicon glyphicon-download" aria-hidden="true"></span>
                </a>
            </div>
        </ul>

        <div id='content' class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="description">
                <div class="specs">
                    <div class="row spec-row">
                        <?php if(Mmp_Api_Boat_Helper::has_boat_category('dimensions', $boat)) : ?>
                            <div class="col-sm-6 col-xs-12">
                                <h4><?php _e('Builder', 'theme-essential-elite'); ?> / <?php _e('Designer', 'theme-essential-elite'); ?></h4>
                                <?php if(!empty($boat['ModelYear'])) : ?>
                                    <div><span><?php _e('Year', 'theme-essential-elite'); ?>:</span> <?php echo $boat['ModelYear']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['BuilderName'])) : ?>
                                    <div><span><?php _e('Builder', 'theme-essential-elite'); ?>:</span> <?php echo $boat['BuilderName']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['DesignerName'])) : ?>
                                    <div><span><?php _e('Designer', 'theme-essential-elite'); ?>:</span> <?php echo $boat['DesignerName']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['BoatHullMaterialCode'])) : ?>
                                    <div><span><?php _e('Construction', 'theme-essential-elite'); ?>:</span> <?php echo $boat['BoatHullMaterialCode']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['BoatKeelCode'])) : ?>
                                    <div><span><?php _e('Boat Keel', 'theme-essential-elite'); ?>:</span> <?php echo $boat['BoatKeelCode']; ?> </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(Mmp_Api_Boat_Helper::has_boat_category('engines', $boat)) : ?>
                            <div class="col-sm-6 col-xs-12">
                                <h4><?php _e('Engines', 'theme-essential-elite'); ?> / <?php _e('Speed', 'theme-essential-elite'); ?></h4>

                                <?php if(!empty($boat['NumberOfEngines'])) : ?>
                                    <div><span><?php _e('Engines', 'theme-essential-elite'); ?>:</span> <?php echo $boat['NumberOfEngines']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['Engines'][0]['Type'])) : ?>
                                    <div><span><?php _e('Engine Type', 'theme-essential-elite'); ?>:</span> <?php echo $boat['Engines'][0]['Type']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['TotalEnginePowerQuantity'])) : ?>
                                    <div><span><?php _e('Engine Power', 'theme-essential-elite'); ?>:</span> <?php echo $boat['TotalEnginePowerQuantity']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['CruisingSpeedMeasure'])) : ?>
                                    <div><span><?php _e('Cruising Speed', 'theme-essential-elite'); ?>:</span> <?php echo $boat['CruisingSpeedMeasure']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['PropellerCruisingSpeed'])) : ?>
                                    <div><span><?php _e('Propeller Cruising Speed', 'theme-essential-elite'); ?>:</span> <?php echo $boat['PropellerCruisingSpeed']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['MaximumSpeedMeasure'])) : ?>
                                    <div><span><?php _e('Maximum Speed', 'theme-essential-elite'); ?>:</span> <?php echo $boat['MaximumSpeedMeasure']; ?> </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row spec-row">

                        <?php if(Mmp_Api_Boat_Helper::has_boat_category('dimensions', $boat)) : ?>
                            <div class="col-sm-6 col-xs-12">
                                <h4><?php _e('Dimensions', 'theme-essential-elite'); ?></h4>
                                <?php if(!empty($boat['NominalLength'])) : ?>
                                    <div><span><?php _e('Nominal Length', 'theme-essential-elite'); ?>:</span> <?php echo $boat['NominalLength']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['LengthOverall'])) : ?>
                                    <div><span><?php _e('Lengh Overall', 'theme-essential-elite'); ?>:</span> <?php echo $boat['LengthOverall']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['BeamMeasure'])) : ?>
                                    <div><span><?php _e('Beam', 'theme-essential-elite'); ?>:</span> <?php echo $boat['BeamMeasure']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['MaximumSpeedMeasure'])) : ?>
                                    <div><span><?php _e('Maximum Speed', 'theme-essential-elite'); ?>:</span> <?php echo $boat['MaximumSpeedMeasure']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['MaxDraft'])) : ?>
                                    <div><span><?php _e('Max Draft', 'theme-essential-elite'); ?>:</span> <?php echo $boat['MaxDraft']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['DriveUp'])) : ?>
                                    <div><span><?php _e('Drive Up', 'theme-essential-elite'); ?>:</span> <?php echo $boat['DriveUp']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['DisplacementMeasure'])) : ?>
                                    <div><span><?php _e('Displacement', 'theme-essential-elite'); ?>:</span> <?php echo $boat['DisplacementMeasure']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['BallastWeightMeasure'])) : ?>
                                    <div><span><?php _e('Ballast', 'theme-essential-elite'); ?>:</span> <?php echo $boat['BallastWeightMeasure']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['BridgeClearanceMeasure'])) : ?>
                                    <div><span><?php _e('Bridge Clearance', 'theme-essential-elite'); ?>:</span> <?php echo $boat['BridgeClearanceMeasure']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['FreeBoardMeasure'])) : ?>
                                    <div><span><?php _e('Free Board', 'theme-essential-elite'); ?>:</span> <?php echo $boat['FreeBoardMeasure']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['CabinHeadroomMeasure'])) : ?>
                                    <div><span><?php _e('Cabin Headroom', 'theme-essential-elite'); ?>:</span> <?php echo $boat['CabinHeadroomMeasure']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['DryWeightMeasure'])) : ?>
                                    <div><span><?php _e('Dry Weight', 'theme-essential-elite'); ?>:</span> <?php echo $boat['DryWeightMeasure']; ?> </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(Mmp_Api_Boat_Helper::has_boat_category('tanks', $boat)) : ?>
                            <div class="col-sm-6 col-xs-12">
                                <h4><?php _e('Tanks', 'theme-essential-elite'); ?></h4>

                                <?php if(!empty($boat['FuelTankCountNumeric'])) : ?>
                                    <div><span><?php _e('Fuel Tanks', 'theme-essential-elite'); ?>:</span> <?php echo $boat['FuelTankCountNumeric']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['FuelTankCapacityMeasure'])) : ?>
                                    <div><span><?php _e('Fuel Tank Capacity', 'theme-essential-elite'); ?>:</span> <?php echo $boat['FuelTankCapacityMeasure']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['WaterTankCountNumeric'])) : ?>
                                    <div><span><?php _e('Water Tanks', 'theme-essential-elite'); ?>:</span> <?php echo $boat['WaterTankCountNumeric']; ?> </div>
                                <?php endif; ?>

                                <?php if(!empty($boat['WaterTankCapacityMeasure'])) : ?>
                                    <div><span><?php _e('Water Tank Capacity', 'theme-essential-elite'); ?>:</span> <?php echo $boat['WaterTankCapacityMeasure']; ?> </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>
                <br />
                <?php if(!empty($boat['GeneralBoatDescription'])) : ?>
                    <div class="description row">
                        <?php foreach($boat['GeneralBoatDescription'] as $desc) : ?>
                            <div class="col-lg-12"><?php echo $desc ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>


            <?php if(!empty($boat['AdditionalDetailDescription'])) : ?>
                <div role="tabpanel" class="tab-pane" id="specification">
                    <div class="row">
                        <?php foreach($boat['AdditionalDetailDescription'] as $desc) : ?>
                            <div class="col-lg-12"><?php echo $desc ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <!-- MAIN CONTENT END -->
    <!-- SIDEBAR CONTENT -->
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">

        <div class="contact-title">
            <h3 class="text-center"><?php _e('Contact Us', 'theme-essential-elite'); ?></h3>
        </div>
        <?php
        the_widget(
            'DMMContactFormWidget',
            array(),
            'title='.$title
            .'&ModelYear='.$boat['ModelYear']
            .'&MakeString='.$boat['MakeString']
            .'&Model='.$boat['Model']
        );
        ?>

        <div class="social-add">
            <?php if( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) : ?>
                <?php
                ADDTOANY_SHARE_SAVE_KIT(array(
                    'linkname' => sprintf(__('%s Showroom'), $title),
                    'linkurl' => (is_ssl() ? 'https://' : 'http://' ) . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI']
                ) ); ?>
            <?php endif; ?>
        </div>

        <div class="more-from">
            <h3 class="text-center more-text"><?php _e(sprintf('More From %s', $boat['MakeString']), 'theme-essential-elite'); ?></h3>
            <hr />
            <?php if(!empty($post->more_from_make)) : ?>
                <?php foreach($post->more_from_make as $additional_boat) : ?>
                <div class="col-lg-12 col-md-12 details-boat-item">
                    <div class="oem-model-single">
                        <div class="oem-boat-title">
                            <?php echo $additional_boat['ModelYear'] ?>
                            <?php echo $additional_boat['MakeString'] ?>
                            <span><?php echo $additional_boat['Model'] ?></span>
                        </div>
                        <div class="thumb">
                            <a href="<?php echo Showrooms_URL_Helper::get_model_details_url(array('DocumentID' => $additional_boat['DocumentID'], 'Year' => $boat['ModelYear'], 'MakeModel' => $boat['MakeString'] . '-' . $boat['Model'])); ?>">
                                <?php echo Showrooms_Helper::get_boat_image($additional_boat, true); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- SIDEBAR CONTENT END -->
</div>
<br />