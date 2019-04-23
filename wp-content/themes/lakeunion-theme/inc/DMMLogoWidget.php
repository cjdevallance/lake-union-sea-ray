<?php

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!');


class DMMLogoWidget extends WP_Widget {

    /**
     * DMMLogoWidget Constructor
     *
     * @since DMM Logo Widget 1.0
     *
     */
    function __construct() {
        $widget_ops = array();
        $control_ops = array();
        parent::__construct(
            'DMMLogoWidget',
            __('Logo', 'lakeunion-theme'),
            $widget_ops,
            $control_ops
        );
    }

    /**
     * Prepare presentation layer
     *
     * @since DMM Logo Widget 1.0
     *
     */
    function getPresentationLayer($args) {

        global $wp;

        // overwrite default options
        $options = wp_parse_args( $args, $this->widget_options );

        $logo_src = get_option('logo_setting_field');

        ///////////// Open buffer
        ob_start();
        ?>
        <a href="<?php echo get_home_url(); ?>">
            <?php if ($logo_src['logo'] != ''): ?>
                <img src="<?php echo $logo_src['logo']; ?>" class="img-responsive"/>
            <?php else: ?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/logo.jpg" class="img-responsive">
            <?php endif; ?>
        </a>
        <?php
        $output = ob_get_contents(); ///////////// Close buffer
        ob_end_clean(); ///////////// Clear buffer
        return $output;
    }

    /**
     * DOM elements for presentation
     *
     * @since DMM Logo Widget 1.0
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo $this->getPresentationLayer($args);
        echo $args['after_widget'];
    }

}
