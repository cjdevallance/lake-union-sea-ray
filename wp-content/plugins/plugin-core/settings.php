<?php 
$mmp_api_key = get_option('mmp_api_key');
$imt_party_id = get_option('imt_party_id');
$provisioning_url = get_option('provisioning_ws_url');
?>

<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) ?>resources/css/admin.css" />

<?php if( isset($_GET['settings-updated']) ) : ?>
    <?php if(empty($mmp_api_key) || empty($imt_party_id)) : ?>
    <div id="message-error" class="error">
        <p><strong><?php _e('MMP API Key and IMT Party ID are required for this plugin!', 'oem-showrooms'); ?></strong></p>
    </div>   
    <?php endif; ?>    
<?php endif; ?>

<div class="wrap">
<h2><?php _e('Core Plugin Settings', 'oem-showrooms'); ?></h2>
<form method="post" action="options.php" id="form-core-settings">

    <?php settings_fields( 'core-settings-group' ); ?>
    <?php do_settings_sections( 'core-settings-group' ); ?>
    
    <fieldset>
    <legend><?php _e('General Settings', 'oem-showrooms'); ?></legend>
    <table class="form-table">
        <?php 
        $provUrl = get_option('provisioning_ws_url');
        $provUrl = !empty($provUrl) ? $provUrl : 'http://account.boatwizard.com/prov-ws';
        ?>
        <tr valign="top">
        <th scope="row"><?php _e('Provisioning Service', 'plugin-core'); ?> <span class="red">*</span></th>
        <td><input type="text" name="provisioning_ws_url" value="<?php echo esc_attr( $provUrl ); ?>" /></td>
        </tr>
    
    
        <tr valign="top">
        <th scope="row"><?php _e('IMT Party ID', 'plugin-core'); ?> <span class="red">*</span></th>
        <td><input type="text" name="imt_party_id" value="<?php echo esc_attr( get_option('imt_party_id') ); ?>" /></td>
        </tr>
    
        <tr valign="top">
        <th scope="row"><?php _e('MMP API Key', 'plugin-core'); ?> <span class="red">*</span></th>
        <td><input type="text" name="mmp_api_key" value="<?php echo esc_attr( get_option('mmp_api_key') ); ?>" /></td>
        </tr>
        
    </table>
    </fieldset>

    <?php echo submit_button(); ?>
</form>
</div>


