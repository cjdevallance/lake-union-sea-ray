<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) ?>resources/css/oem-showrooms.css" />

<?php if( isset($_GET['settings-updated']) ) : ?>
    <div id="message-schedule" class="updated">
        <p><strong><?php _e( sprintf('Selected brands import is scheduled to run %s.
            <br/>Upcoming update is on %s', get_option(OEM_SHOWROOMS_PREFIX . 'import_frequency'), 
            date("M d, Y H:i:s", wp_next_scheduled('showrooms_import_event'))) ) ?></strong></p>
    </div>    
<?php endif; ?>

<?php if( empty($mmp_api_key) ) :?>
    <div id="message-error" class="error">
        <p><strong><?php _e('MMP API Key and IMT Party ID are required for this plugin! Please enable core plugin and make sure these settings are updated before you configure this plugin.', 'plugin-oem-showrooms'); ?></strong></p>
    </div>
<?php endif; ?>

<?php if( empty($brands) ) :?>
    <div id="message-error" class="error">
        <p><strong>
        <?php _e('No supported brands found. Please run a successful import first!', 'plugin-oem-showrooms'); ?>
        <a href="options-general.php?page=oem-showrooms&request=run-import"><?php _e('Run Import', 'plugin-oem-showrooms') ?></a>
        </strong></p>
    </div>
<?php endif; ?>


<div class="wrap">
<h2><?php _e('New Boat Showrooms Settings', 'plugin-oem-showrooms'); ?></h2>
<form method="post" action="options.php" id="form-showrooms-settings">

    <?php settings_fields( 'showrooms-settings-group' ); ?>
    <?php do_settings_sections( 'showrooms-settings-group' ); ?>
    
    <fieldset>
    <legend><?php _e('General Settings', 'plugin-oem-showrooms'); ?></legend>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('Provisioning Service URL', 'plugin-oem-showrooms'); ?></th>
        <td>
            <?php echo !empty($provisioning_url) ? esc_attr( $provisioning_url ) : '<span class="red bold">' . __('Not Set', 'plugin-oem-showrooms') . '</span>' ?>
        </td>
        </tr>
    
    
        <tr valign="top">
        <th scope="row"><?php _e('IMT Party ID', 'oplugin-oem-showrooms'); ?></th>
        <td>
            <?php echo !empty($imt_party_id) ? esc_attr( $imt_party_id ) : '<span class="red bold">' . __('Not Set', 'plugin-oem-showrooms') . '</span>' ?>
         </td>
        </tr>
    
        <tr valign="top">
        <th scope="row"><?php _e('MMP API Key', 'plugin-oem-showrooms'); ?></th>
        <td>
            <?php echo !empty($mmp_api_key) ? esc_attr( $mmp_api_key ) : '<span class="red bold">' . __('Not Set', 'plugin-oem-showrooms') . '</span>' ?>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row"><?php _e('Import Frequency', 'plugin-oem-showrooms'); ?></th>
        <td>
            <select name="oem_showrooms_import_frequency" id="import_frequency">
                <option value="daily"><?php _e('Daily', 'plugin-oem-showrooms'); ?></option>
                <option value="weekly"><?php _e('Weekly', 'plugin-oem-showrooms'); ?></option>
                <option value="biweekly"><?php _e('Bi-Weekly', 'plugin-oem-showrooms'); ?></option>
                <option value="monthly"><?php _e('Monthly', 'plugin-oem-showrooms'); ?></option>
            </select><br />
            <small><?php _e('How often do we import supported brands?', 'plugin-oem-showrooms'); ?></small>
        </td>
        </tr>
    </table>
    </fieldset>
    
    <fieldset>
    <legend><?php _e('Permalinks for Showrooms', 'plugin-oem-showrooms'); ?></legend>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('Showrooms Details Page', 'plugin-oem-showrooms'); ?> <span class="red">*</span></th>
                <td>
                    <?php echo $landing_page_slug ?>/<input type="text" name="oem_showrooms_detail_url" value="<?php echo esc_attr( $url_showroom_detail ); ?>" /><br />
                    <small><?php _e('Supported dynamic tags'); ?>: [Year], [MakeModel], [DocumentID]<br />
                    <i><?php _e('Example'); ?>: [Year]-[MakeModel]-[DocumentID]</i></small>
                </td>
            </tr>          
        
        </table>
    
    </fieldset>
    
    <fieldset>
    <legend><?php _e('Showroom Landing and Brand Pages', 'plugin-oem-showrooms'); ?></legend>
    <table class="form-table">
    
        <?php if(!empty($brands)) : ?>        
        <tr valign="top">
            <th scope="row"><?php _e('Showrooms Landing Page', 'plugin-oem-showrooms'); ?> <span class="red"></span></th>
            <td><?php wp_dropdown_pages( array(
                'name' => 'oem_showrooms_landing_page_id',
                'selected' => get_option('oem_showrooms_landing_page_id')
        ) ); ?><br />
                <small><?php _e('This is manufacturers landing page where the list of supported brands is displayed.', 'plugin-oem-showrooms'); ?></small>        
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Showrooms Detail Page', 'plugin-oem-showrooms'); ?> <span class="red"></span></th>
            <td><?php wp_dropdown_pages( array(
                'name' => 'oem_showrooms_detail_page_id',
                'selected' => get_option('oem_showrooms_detail_page_id')
        ) ); ?><br />
            <small><?php _e('This is manufacturer model detail page', 'plugin-oem-showrooms'); ?></small>
        </td>
        </tr>
        
        <tr>
            <th></th>
            <td></td>
            <td><small>Enter comma separated values for listings you want to ignore. <br />
            Terms accepted are either DocumentID or Category name (as it appears in brand page. <br />
            Example: <b>Motor Yachts,4818672,4842428</b> will ignore the 2 listing and entire Motor Yachts</small></td>
        </tr>
        <?php foreach($brands as $brand_key => $brand) : ?>
        <tr valign="top">
            <th scope="row"><?php _e( sprintf('%s Page', $brand['name']) ); ?> <span class="red"></span></th>
            <td class="col-sm">
                <?php
                echo Showrooms_Helper::get_showroom_brands_dropdown(
                    'oem_showrooms_brand_page_id_' . $brand_key, 
                    get_option('oem_showrooms_brand_page_id_' . $brand_key),
                    $brand['id'],
                    'page-showroom-models.php'); 
                ?>
            </td>
            <td>
                <?php _e('Exclude') ?>: 
                <input type="text" name="oem_showrooms_exclude_<?php echo $brand['id'] ?>" value="<?php echo esc_attr( $excludes[$brand['id']] ); ?>" />
            </td>
        </tr>
        <?php endforeach; ?>
        
        <?php endif; ?>    
    </table>
    </fieldset>    
    

    <?php echo submit_button(); ?>
</form>
</div>

<?php 
$brands_updated = get_option('oem_showrooms_brands_updated');
$brands = get_option('oem_showrooms_brands');
if(!empty($brands)) {
    $brands = json_decode($brands, 1);
}

$oems_updated = get_option('oem_showrooms_updated');
?>

<div class="oem-block">
    <h3><?php _e('Brand Imports', 'plugin-oem-showrooms'); ?></h3>
    <b><?php _e('Last imported on', 'plugin-oem-showrooms'); ?>:</b> 
        <?php echo !empty($brands) && !empty($brands_updated) ? date('M d Y, H:i', $brands_updated) : __('Never', 'plugin-oem-showrooms'); ?><br />
    <?php if(!empty($brands)) : ?>
    <p><?php _e('Below is the list of brands supported.', 'plugin-oem-showrooms'); ?> <br />
    <?php _e('These are the brands that will show under manufacturer showrooms section of the website.', 'plugin-oem-showrooms'); ?></p>
    
    <div class="supported-brands">
    <?php 
    foreach($brands as $brand_key => $brand_array) :
        $img_class = !empty($brand_array['logo']) ? '' : 'nologo';
        echo '<div class="supported-brand">';
        echo '  <div align="center">' . $brand_array['name'] . '</div>';
        echo '  <img class="' . $img_class . '" src="' . $brand_array['logo'] . 
            '" title="' . $brand_array['id'] . '" />';
        echo '</div>';        
    endforeach;
    ?>
    <?php endif; ?>
    </div>
    <br />
</div>


<?php 
$frequency = get_option(OEM_SHOWROOMS_PREFIX . 'import_frequency');
if(!empty($frequency)) :
?>
<script type="text/javascript">
jQuery(function() {
	jQuery('#import_frequency option[value=<?php echo $frequency ?>]').prop('selected', true);
});
</script>
<?php 
endif;
?>

