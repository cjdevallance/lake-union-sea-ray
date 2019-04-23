<?php

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!');


class DMMSocialMediaWidget extends WP_Widget {

    /**
     * DMMSocialMediaWidget Constructor
     *
     * @since DMM Social Media Widget 1.0
     *
     */
    function __construct() {
        $widget_ops = array();
        $control_ops = array();
        parent::__construct(
            'DMMSocialMediaWidget',
            __('Social Media Links', 'lakeunion-theme'),
            $widget_ops,
            $control_ops
        );
    }

    /**
     * Prepare presentation layer
     *
     * @since DMM Social Media Widget 1.0
     *
     */
    function getPresentationLayer($args) {

        global $wp;

        // overwrite default options
        $options = wp_parse_args( $args, $this->widget_options );

        $social_buttons = get_option('social_media_setting_field');

        ///////////// Open buffer
        ob_start();
        ?>
            <?php if ($social_buttons['facebook'] != ''): ?>
                <a class="btn btn-social-icon btn-facebook" href="<?php echo $social_buttons['facebook']; ?>"
                   target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
            <?php endif; ?>
            <?php if ($social_buttons['google plus'] != ''): ?>
                <a class="btn btn-social-icon btn-google" href="<?php echo $social_buttons['google plus']; ?>" target="_blank">
                    <i class="fa fa-google-plus"></i>
                </a>
            <?php endif; ?>
            <?php if ($social_buttons['twitter'] != ''): ?>
                <a class="btn btn-social-icon btn-twitter" href="<?php echo $social_buttons['twitter']; ?>" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
            <?php endif; ?>
            <?php if ($social_buttons['YouTube'] != ''): ?>
                <a class="btn btn-social-icon btn-pinterest" href="<?php echo $social_buttons['YouTube']; ?>" target="_blank">
                    <i class="fa fa-youtube"></i>
                </a>
            <?php endif; ?>
            <?php if ($social_buttons['instagram'] != ''): ?>
                <a class="btn btn-social-icon btn-instagram" href="<?php echo $social_buttons['instagram']; ?>" target="_blank">
                    <i class="fa fa-instagram"></i>
                </a>
            <?php endif; ?>
        <?php
        $output = ob_get_contents(); ///////////// Close buffer
        ob_end_clean(); ///////////// Clear buffer
        return $output;
    }

    /**
     * DOM elements for presentation
     *
     * @since DMM Social Media Widget 1.0
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo $this->getPresentationLayer($args);
        echo $args['after_widget'];
    }

}
