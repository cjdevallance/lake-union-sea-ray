<?php

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!');


class DMMPrimaryLocationHoursWidget extends WP_Widget {

    /**
     * DMMPrimaryLocationHoursWidget Constructor
     *
     * @since DMM Primary Location Hours Widget 1.0
     *
     */
    function __construct() {
        $widget_ops = array();
        $control_ops = array();
        parent::__construct(
            'DMMPrimaryLocationHoursWidget',
            __('Primary Location Hours', 'lakeunion-theme'),
            $widget_ops,
            $control_ops
        );
    }

    /**
     * Prepare presentation layer
     *
     * @since DMM Primary Location Hours Widget 1.0
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
            <h3><?php _e('Hours', 'lakeunion-theme'); ?></h3>
            <!-- Hours -->
            <div class="row">
                <div class="col-xs-5 col-sm-4 col-lg-4">
                    <?php _e('Monday:', 'lakeunion-theme'); ?>
                </div>
                <div class="col-xs-7 col-sm-8 col-lg-8">
                    <?php echo is_array($primary_location) && $primary_location['monday']['from'] != '' ? $primary_location['monday']['from'] : '8:00am' ?>
                    &nbsp;-&nbsp;
                    <?php echo is_array($primary_location) && $primary_location['monday']['to'] != '' ? $primary_location['monday']['to'] : '6:00pm' ?>
                </div>
                <div class="col-xs-5 col-sm-4 col-lg-4">
                    <?php _e('Tuesday:', 'lakeunion-theme'); ?>
                </div>
                <div class="col-xs-7 col-sm-8 col-lg-8">
                    <?php echo is_array($primary_location) && $primary_location['tuesday']['from'] != '' ? $primary_location['tuesday']['from'] : '8:00am' ?>
                    &nbsp;-&nbsp;
                    <?php echo is_array($primary_location) && $primary_location['tuesday']['to'] != '' ? $primary_location['tuesday']['to'] : '6:00pm' ?>
                </div>
                <div class="col-xs-5 col-sm-4 col-lg-4">
                    <?php _e('Wednesday:', 'lakeunion-theme'); ?>
                </div>
                <div class="col-xs-7 col-sm-8 col-lg-8">
                    <?php echo is_array($primary_location) && $primary_location['wednesday']['from'] != '' ? $primary_location['wednesday']['from'] : '8:00am' ?>
                    &nbsp;-&nbsp;
                    <?php echo is_array($primary_location) && $primary_location['wednesday']['to'] != '' ? $primary_location['wednesday']['to'] : '6:00pm' ?>
                </div>
                <div class="col-xs-5 col-sm-4 col-lg-4">
                    <?php _e('Thursday:', 'lakeunion-theme'); ?>
                </div>
                <div class="col-xs-7 col-sm-8 col-lg-8">
                    <?php echo is_array($primary_location) && $primary_location['thursday']['from'] != '' ? $primary_location['thursday']['from'] : '8:00am' ?>
                    &nbsp;-&nbsp;
                    <?php echo is_array($primary_location) && $primary_location['thursday']['to'] != '' ? $primary_location['thursday']['to'] : '6:00pm' ?>
                </div>
                <div class="col-xs-5 col-sm-4 col-lg-4">
                    <?php _e('Friday:', 'lakeunion-theme'); ?>
                </div>
                <div class="col-xs-7 col-sm-8 col-lg-8">
                    <?php echo is_array($primary_location) && $primary_location['friday']['from'] != '' ? $primary_location['friday']['from'] : '8:00am' ?>
                    &nbsp;-&nbsp;
                    <?php echo is_array($primary_location) && $primary_location['friday']['to'] != '' ? $primary_location['friday']['to'] : '6:00pm' ?>
                </div>
                <div class="col-xs-5 col-sm-4 col-lg-4">
                    <?php _e('Saturday:', 'lakeunion-theme'); ?>
                </div>
                <div class="col-xs-7 col-sm-8 col-lg-8">
                    <?php echo is_array($primary_location) && $primary_location['saturday']['from'] != '' ? $primary_location['saturday']['from'] : '8:00am' ?>
                    &nbsp;-&nbsp;
                    <?php echo is_array($primary_location) && $primary_location['saturday']['to'] != '' ? $primary_location['saturday']['to'] : '6:00pm' ?>
                </div>
                <div class="col-xs-5 col-sm-4 col-lg-4">
                    <?php _e('Sunday:', 'lakeunion-theme'); ?>
                </div>
                <div class="col-xs-7 col-sm-8 col-lg-8">
                    <?php echo is_array($primary_location) && $primary_location['sunday']['from'] != '' ? $primary_location['sunday']['from'] : '8:00am' ?>
                    &nbsp;-&nbsp;
                    <?php echo is_array($primary_location) && $primary_location['sunday']['to'] != '' ? $primary_location['sunday']['to'] : '6:00pm' ?>
                </div>
            </div>
        <?php
        $output = ob_get_contents(); ///////////// Close buffer
        ob_end_clean(); ///////////// Clear buffer
        return $output;
    }

    /**
     * DOM elements for presentation
     *
     * @since DMM Primary Location Hours Widget 1.0
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo $this->getPresentationLayer($args);
        echo $args['after_widget'];
    }

}
