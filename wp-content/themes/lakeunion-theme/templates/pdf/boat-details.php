<html>
<head>
<title><?php echo $title ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/templates/pdf/boat-details.css" />
</head>
<body>

<!-- fixed header and footer -->
<div id="header">
    <?php if(class_exists('Business_Information_Helper')) : ?>
    <img class="header-logo" src="<?php echo Business_Information_Helper::get_logo_url(); ?>" alt="" />
    <?php endif; ?>
</div>
<div id="footer">
    <?php if(class_exists('Business_Information_Helper')) : ?>
        <?php $location = Business_Information_Helper::get_main_location(); ?>
        <?php echo get_bloginfo('name'); ?>
        
        <?php if(!empty($location['phone'])) : ?>
            - <?php _e('Tel') ?>: <?php echo $location['phone']; ?>
        <?php endif; ?>
        
        <?php if(!empty($location['email']) || false) : ?>
           <br /><?php echo $location['email']; ?>
        <?php endif; ?>     
        
        <br />
        <?php if(!empty($location['address'])) : ?>
            <?php echo $location['address']; ?>
            <?php echo $location['city']; ?>
            <?php echo $location['state']; ?>
            <?php if(!empty($location['post code'])) : ?>
                ,<?php echo $location['post code']; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>  

<!-- Content Area -->
<div id="content">
    <h1><?php echo $boat['ModelYear'] ?> <?php echo $boat['MakeString'] ?> <?php echo $boat['Model'] ?></h1>
    
    <?php if(!empty($boat['Images'])) : ?>
    <div class="main-image">      
        <img src="<?php echo $boat['Images'][0]['Uri']; ?>" alt="" />               
    </div>
    <?php endif; ?>
    
    <?php if(!empty($boat['Price']) && !empty($boat['referer']) && $boat['referer'] == 'inventory') : ?>
    <h4><?php _e('Price', 'theme-essential-elite'); ?>: <?php echo Inventory_Helper::get_price_string($boat); ?></h4>
    <?php endif; ?>
    
    <!-- Specifications -->
    <h2><?php _e('Specifications', 'theme-essential-elite'); ?></h2>
    <div class="specs">
        <table width="100%">
            <tr>
                <td valign="top">
                    <table width="100%">
                        <?php if(Mmp_Api_Boat_Helper::has_boat_category('builder', $boat)) : ?>
                            <tr>
                                <th colspan="2"><h3><?php _e('Builder', 'theme-essential-elite'); ?>/<?php _e('Designer', 'theme-essential-elite'); ?></h3></th>
                            </tr>                      
                            <?php if(!empty($boat['ModelYear'])) : ?>
                            <tr>
                                <th><?php _e('Year', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'ModelYear');  ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($boat['BuilderName'])) : ?>
                            <tr>
                                <th><?php _e('Builder', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'BuilderName');  ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($boat['DesignerName'])) : ?>
                            <tr>
                                <th><?php _e('Designer', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'DesignerName');  ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($boat['BoatHullMaterialCode'])) : ?>
                            <tr>
                                <th><?php _e('Construction', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'BoatHullMaterialCode');  ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($boat['BoatKeelCode'])) : ?>
                            <tr>
                                <th><?php _e('Boat Keel', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'BoatKeelCode');  ?></td>
                            </tr>  
                            <?php endif; ?>
                            <?php endif; ?>
                        
                        <?php if(Mmp_Api_Boat_Helper::has_boat_category('engines', $boat)) : ?>
                            <tr>
                                <th colspan="2"><h3><?php _e('Engines', 'theme-essential-elite'); ?> / <?php _e('Speed', 'theme-essential-elite'); ?></h3></th>
                            </tr>
                            
                            <!-- engines -->
                            <?php if(!empty($boat['NumberOfEngines'])) : ?>
                            <tr>
                                <th><?php _e('Engines', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'NumberOfEngines');  ?></td>
                            </tr>  
                            <?php endif; ?>   
                            <?php if(!empty($boat['Engines'][0]['Type'])) : ?>
                            <tr>
                                <th><?php _e('Engine Type', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo $boat['Engines'][0]['Type'];  ?></td>
                            </tr>  
                            <?php endif; ?>                         
                            <?php if(!empty($boat['TotalEnginePowerQuantity'])) : ?>
                            <tr>
                                <th><?php _e('Engine Power', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'TotalEnginePowerQuantity');  ?></td>
                            </tr> 
                            <?php endif; ?> 
                             
                            <!-- speed -->          
                            <?php if(!empty($boat['CruisingSpeedMeasure'])) : ?>
                            <tr>
                                <th><?php _e('Cruising Speed', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'CruisingSpeedMeasure');  ?></td>
                            </tr> 
                            <?php endif; ?>   
                            <?php if(!empty($boat['PropellerCruisingSpeed'])) : ?>
                            <tr>
                                <th><?php _e('Propeller Cruising Speed', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'PropellerCruisingSpeed');  ?></td>
                            </tr> 
                            <?php endif; ?>    
                            <?php if(!empty($boat['MaximumSpeedMeasure'])) : ?>
                            <tr>
                                <th><?php _e('Maximum Speed', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'MaximumSpeedMeasure');  ?></td>
                            </tr> 
                            <?php endif; ?>  
                        <?php endif; ?>                                                                     
                                                                           
                                                                    
                    </table>
                 </td>
                 <td valign="top">
                    <table width="100%">
                        <?php if(Mmp_Api_Boat_Helper::has_boat_category('dimensions', $boat)) : ?>
                            <tr>
                                <th colspan="2"><h3><?php _e('Dimensions', 'theme-essential-elite'); ?></h3></th>
                            </tr>
                            <?php if(!empty($boat['NominalLength'])) : ?>
                            <tr>
                                <th><?php _e('Nominal Length', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'NominalLength');  ?></td>
                            </tr>
                            <?php endif; ?>   
                            <?php if(!empty($boat['LengthOverall'])) : ?>
                            <tr>
                                <th><?php _e('Length Overall', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'LengthOverall');  ?></td>
                            </tr>
                            <?php endif; ?>   
                            <?php if(!empty($boat['BeamMeasure'])) : ?>
                            <tr>
                                <th><?php _e('Beam', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'BeamMeasure');  ?></td>
                            </tr>
                            <?php endif; ?>   
                            <?php if(!empty($boat['MaxDraft'])) : ?>
                            <tr>
                                <th><?php _e('Max Draft', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'MaxDraft');  ?></td>
                            </tr> 
                            <?php endif; ?>   
                            <?php if(!empty($boat['DriveUp'])) : ?>
                            <tr>
                                <th><?php _e('Drive Up', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'DriveUp');  ?></td>
                            </tr> 
                            <?php endif; ?>                          
                            <?php if(!empty($boat['DisplacementMeasure'])) : ?>   
                            <tr>
                                <th><?php _e('Displacement', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'DisplacementMeasure');  ?></td>
                            </tr> 
                            <?php endif; ?>    
                            <?php if(!empty($boat['BallastWeightMeasure'])) : ?>         
                            <tr>
                                <th><?php _e('Ballast', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'BallastWeightMeasure');  ?></td>
                            </tr> 
                            <?php endif; ?>     
                            <?php if(!empty($boat['BridgeClearanceMeasure'])) : ?>
                            <tr>
                                <th><?php _e('Bridge Clearance', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'BridgeClearanceMeasure');  ?></td>
                            </tr>  
                            <?php endif; ?>    
                            <?php if(!empty($boat['FreeBoardMeasure'])) : ?>
                            <tr>
                                <th><?php _e('Free Board', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'FreeBoardMeasure');  ?></td>
                            </tr>  
                            <?php endif; ?>        
                            <?php if(!empty($boat['CabinHeadroomMeasure'])) : ?>
                            <tr>
                                <th><?php _e('Cabin Headroom', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'CabinHeadroomMeasure');  ?></td>
                            </tr>  
                            <?php endif; ?> 
                            <?php if(!empty($boat['DryWeightMeasure'])) : ?>
                            <tr>
                                <th><?php _e('Dry Weight', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'DryWeightMeasure');  ?></td>
                            </tr>  
                            <?php endif; ?>   
                        <?php endif; ?>                                                                                          
                        
                        <?php if(Mmp_Api_Boat_Helper::has_boat_category('tanks', $boat)) : ?>
                            <tr>
                                <th colspan="2"><h3><?php _e('Tanks', 'theme-essential-elite'); ?></h3></th>
                            </tr>    
                            
                            <?php if(!empty($boat['FuelTankCountNumeric'])) : ?>
                            <tr>
                                <th><?php _e('Fuel Tanks', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'FuelTankCountNumeric');  ?></td>
                            </tr>  
                            <?php endif; ?>   
                            <?php if(!empty($boat['FuelTankCapacityMeasure'])) : ?>
                            <tr>
                                <th><?php _e('Fuel Tank Capacity', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'FuelTankCapacityMeasure');  ?></td>
                            </tr>  
                            <?php endif; ?>
                            <?php if(!empty($boat['WaterTankCountNumeric'])) : ?>         
                            <tr>
                                <th><?php _e('Water Tanks', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'WaterTankCountNumeric');  ?></td>
                            </tr>
                            <?php endif; ?>    
                            <?php if(!empty($boat['WaterTankCapacityMeasure'])) : ?>
                            <tr>
                                <th><?php _e('Water Tank Capacity', 'theme-essential-elite'); ?>:</th>
                                <td><?php echo Mmp_Api_Boat_Helper::get_field_value($boat, 'WaterTankCapacityMeasure');  ?></td>
                            </tr> 
                            <?php endif; ?> 
                        <?php endif; ?>                                                                                                                              
                    </table>             
                 </td>
            </tr>                           
        </table>
              
    </div>
    
    <!-- Additional Details -->
    <h2><?php _e('Description', 'theme-essential-elite'); ?></h2>
    <?php if(!empty($boat['GeneralBoatDescription'])) : ?>
    <div class="description row">
        <?php foreach($boat['GeneralBoatDescription'] as $desc) : ?>
        <div><?php echo $desc ?></div><br />
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($boat['AdditionalDetailDescription'])) : ?>
    <div class="description">
        <?php foreach($boat['AdditionalDetailDescription'] as $desc) : ?>
        <div><?php echo $desc ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

</body>
</html>