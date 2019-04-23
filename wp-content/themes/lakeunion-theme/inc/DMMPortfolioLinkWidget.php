<?php

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!');


class DMMPortfolioLinkWidget extends WP_Widget {

    /**
     * DMMPortfolioWidget Constructor
     *
     * @since DMM Portfolio Link Widget 1.0
     *
     */
    function __construct() {
        $widget_ops = array();
        $control_ops = array();
        parent::__construct(
            'DMMPortfolioLinkWidget',
            __('Powered By DMM Link', 'lakeunion-theme'),
            $widget_ops,
    $control_ops
        );
    }

    /**
     * Prepare presentation layer
     *
     * @since DMM Portfolio Link Widget 1.0
     *
     */
    function getPresentationLayer($args) {

        global $wp;

        // overwrite default options
        $options = wp_parse_args( $args, $this->widget_options );

        ///////////// Open buffer
        ob_start();
        ?>
            <a href="http://www.dominionmarinemedia.com/websites/portfolio/" target="_blank">
                <span><?php _e('Site By Dominion Marine Media', 'lakeunion-theme'); ?></span>
            </a>
        <?php
        $output = ob_get_contents(); ///////////// Close buffer
        ob_end_clean(); ///////////// Clear buffer
        return $output;
    }

    /**
     * DOM elements for presentation
     *
     * @since DMM Portfolio Link Widget 1.0
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo $this->getPresentationLayer($args);
        echo $args['after_widget'];
    }

}
