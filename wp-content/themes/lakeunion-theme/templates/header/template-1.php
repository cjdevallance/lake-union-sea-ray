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
            console.log('test');
        });
    </script>

</head>

<body <?php body_class(); ?>>

<div class="row header">
    <div class="container">
        <!-- Brand Logo -->
        <div class="col-sm-3 logo">
            <?php the_widget('DMMLogoWidget'); ?>
        </div>
        <!-- Brand Logo END -->

        <!-- Contact Info -->
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 social-media">
            <?php
                the_widget('DMMSocialMediaWidget');
                the_widget('DMMContactUsLinksWidget');
            ?>
            <div class="clearfix"></div>
        </div>
        <!-- Contact Info END -->

        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 navigon">

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
