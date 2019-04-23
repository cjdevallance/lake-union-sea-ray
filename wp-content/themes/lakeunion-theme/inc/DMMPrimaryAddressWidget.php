<?php

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!');


class DMMPrimaryAddressWidget extends WP_Widget {

    /**
     * DMMPrimaryAddressWidget Constructor
     *
     * @since DMM Primary Address Widget 1.0
     *
     */
    function __construct() {
        $widget_ops = array();
        $control_ops = array();
        parent::__construct(
            'DMMPrimaryAddressWidget',
            __('Primary Address', 'lakeunion-theme'),
            $widget_ops,
            $control_ops
        );
    }

    /**
     * Prepare presentation layer
     *
     * @since DMM Primary Address Widget 1.0
     *
     */
    function getPresentationLayer($args) {

        global $wp;

        // overwrite default options
        $options = wp_parse_args( $args, $this->widget_options );

        $primary_location = get_locations();

        ///////////// Open buffer
        ob_start();
        ?>
            <h3><?php echo is_array($primary_location) && $primary_location['name'] != '' ? $primary_location['name'] : 'Company Name' ?></h3>
            <address>
                <?php echo is_array($primary_location) && $primary_location['address'] != '' ? $primary_location['address'] : '795 Folsom Ave, Suite 600' ?>
                <br>
                <?php echo is_array($primary_location) && $primary_location['city'] != '' ? "{$primary_location['city']}," : 'San Francisco,' ?>
                <?php echo is_array($primary_location) && $primary_location['state'] != '' ? "{$primary_location['state']}," : 'CA,' ?>
                <?php echo is_array($primary_location) && $primary_location['country'] != '' ? $primary_location['country'] : 'USA' ?>
                <br>
                <?php echo is_array($primary_location) && $primary_location['postal_code'] != '' ? $primary_location['postal_code'] : '94107' ?>
                <br>
                <abbr title="Phone"><?php _e('Tel:', 'lakeunion-theme'); ?></abbr>
                <a href="tel:<?php echo is_array($primary_location) && $primary_location['phone'] != '' ? $primary_location['phone'] : '(123) 456-7890' ?>">
                    <?php echo is_array($primary_location) && $primary_location['phone'] != '' ? $primary_location['phone'] : '(123) 456-7890' ?>
                </a>
                <br>
                <?php $number_of_locations = get_number_of_locations(); ?>
                <?php if ($number_of_locations > 1): ?>
                    <br>
                    <?php $pages = get_posts(array('post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-contact.php')); ?>
                    <a href='<?php echo "/{$pages[0]->post_name}" ?>'
                       target="_blank"><?php _e('View All Of Our Locations', 'lakeunion-theme'); ?></a>
                <?php endif; ?>
            </address>
        <?php
        $output = ob_get_contents(); ///////////// Close buffer
        ob_end_clean(); ///////////// Clear buffer
        return $output;
    }

    /**
     * DOM elements for presentation
     *
     * @since DMM Primary Address Widget 1.0
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo $this->getPresentationLayer($args);
        echo $args['after_widget'];
    }

}
