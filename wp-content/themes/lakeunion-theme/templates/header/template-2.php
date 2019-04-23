<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package CWTheme
 * @subpackage Essentials
 * @since CW Theme Essentials 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
    <![endif]-->
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title><?php the_title('' ,is_page_template('page-inventory-details.php')? ' '. __('in', 'theme-essential-elite') .' ' .Inventory_Helper::get_location_string($post->inventory['boat']) . ' - ' . get_bloginfo('name'): '')?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo esc_url(get_template_directory_uri()); ?>/style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/ie8-responsive-file-warning.js"></script>
    <![endif]-->
    <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php wp_head(); ?>

    <!-- General js scripts -->
    <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/scripts.js"></script>
    <?php
        // it was explicitly requested to place this javascript
        if(is_plugin_active( 'plugin-midas/dmm-midas.php' )) echo getDTMScript();
    ?>

    <script type="text/javascript">
        jQuery('#new-boat-tabs a').click(function (e) {
            e.preventDefault();
            jQuery(this).tab('show');
        });
    </script>

</head>

<body <?php body_class(); ?>>

<div class="container">
    <div class="row header">
        <div class="col-md-3 header-logo">
            <a href="#">
                <?php $logo_src = get_option('logo_setting_field'); ?>
                <?php if ($logo_src['logo'] != ''): ?>
                    <img src="<?php echo $logo_src['logo']; ?>" class="img-responsive"/>
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/logo.jpg" class="img-responsive">
                <?php endif; ?>
            </a>
        </div>
        <!-- Menu Logo -->
        <div class="col-md-9 header-menu">
            <nav class="navbar navbar-default">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#header-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- WP Generated Menu -->
                <div class="collapse navbar-collapse" id="header-navbar-collapse">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'essentialelite-headermenu',
                        'menu' => 'header_menu',
                        'container' => '',
                        'container_class' => false,
                        'container_id' => false,
                        'menu_class' => 'nav navbar-nav',
                        'menu_id' => false,
                        'echo' => true,
                        'fallback_cb' => 'wp_page_menu',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 0,
                        'walker' => new wp_bootstrap_navwalker()
                    ));
                    ?>
                </div>
                <!-- WP Generated Menu END -->
                <!-- /.container -->
            </nav>
        </div>
        <div class="clearfix"></div>
        <!-- Menu END -->
    </div>
</div>


<!-- Page content needs to be within a container -->
<div class="body-wrap">
    <div class="container">
        <?php
        if (function_exists('yoast_breadcrumb') && !is_front_page()) {
            yoast_breadcrumb('<div class="row breadcrumb"><div class="col-xs-12">', '</div></div>');
        }
        ?>
