<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package CWTheme
 * @subpackage Essentials
 * @since CW Theme Essentials 1.0
 */
?>
<!--
    The header opened a container tab to
    hold the page content within it.
    We close it here.
-->
</div>

<footer class="footer">
    <div class="container">
        <!-- Footer -->
        <div class="row">
            <div class="col-xs-12 col-sm-4 contact-info">
                <?php the_widget('DMMPrimaryAddressWidget'); ?>
            </div>
            <div class="col-xs-12 col-sm-4 hours">
                <?php the_widget('DMMLogoWidget'); ?>
            </div>
            <div class="col-xs-12 col-sm-4 contact-us-links text-center">
                <?php
                    the_widget('DMMSocialMediaWidget');
                    the_widget('DMMContactUsLinksWidget');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <?php the_widget('DMMPortfolioLinkWidget'); ?>
            </div>
        </div>
        <!-- Footer END -->
    </div>
</footer>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script type="text/javascript"
        src="<?php echo esc_url(get_template_directory_uri()); ?>/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript"
        src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery.min.js"></script>
<script type="text/javascript"
        src="<?php echo esc_url(get_template_directory_uri()); ?>/js/bootstrap.min.js"></script>
<script type="text/javascript"
        src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery.smartmenus.min.js"></script>
<script type="text/javascript"
        src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery.smartmenus.bootstrap.min.js"></script>
<script type="text/javascript"
        src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery.validate.min.js"></script>
<?php
    wp_footer();
    if(is_plugin_active( 'plugin-midas/dmm-midas.php' )) echo buildDataBuilder();
?>

</body>
</html>
