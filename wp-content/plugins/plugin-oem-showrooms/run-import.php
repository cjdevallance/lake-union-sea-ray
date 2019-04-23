<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) ?>resources/css/oem-showrooms.css" />

<div class="wrap">
<h2><?php _e('Importing Supported Brands...', 'plugin-oem-showrooms'); ?></h2>

<div class="oem-block">
    <h3><?php _e('Import Details', 'plugin-oem-showrooms'); ?></h3>
    <div class="imported-brands">
         <table width="700" cellspacing="5">
            <tr>
                <td width="250">
                    <b><?php _e('Total number of brands found', 'plugin-oem-showrooms'); ?>:</b>
                </td>
                <td>
                    <b><?php echo (isset($brand_import_stats['total_brands']) ? $brand_import_stats['total_brands']: "--"); ?></b>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php _e('Supported Brands Imported', 'plugin-oem-showrooms'); ?>:</b>
                </td>
                <td>
                    <b><?php echo (isset($brand_import_stats['brands_supported']) ? $brand_import_stats['brands_supported']: "--"); ?></b>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <b><?php _e('Provisioning API Test', 'plugin-oem-showrooms'); ?>:</b>
                </td>
                <td>
                    <b><?php echo (isset($brand_import_stats['http_success']) && !empty($brand_import_stats['http_success']) ? __('Pass', 'plugin-oem-showrooms') : __('Fail', 'plugin-oem-showrooms')); ?></b>
                    <br />
                    <small><?php _e('This test is responsible for checking API connectivity to provisioning. This needs to pass for imports to be successful.', 'plugin-oem-showrooms'); ?></small><br />        
                </td>
            </tr>
            <?php if(isset($brand_import_stats['brands_supported']) && $brand_import_stats['brands_supported'] > 0) : ?>
            <tr>
                <td valign="top">
                    <b><?php _e('MMP API Tests', 'plugin-oem-showrooms'); ?>:</b>                 
                </td>
                <td>
                    <b><?php echo $testMmpSuccess ? __('Pass', 'plugin-oem-showrooms') : __('Fail', 'plugin-oem-showrooms'); ?></b>
                    <br />
                    <small><?php _e('These tests are to ensure that there is showrooms data in Search API for supported brands. If these tests fail then no boat data is available for any of the supported brands.', 'plugin-oem-showrooms'); ?></small>
                </td>
            </tr>
            <?php endif; ?>
         </table>
    </div>
    <div class="imported-listing-data">
        
    </div>
    
</div>
