<?php

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!');


class DMMContactUsLinksWidget extends WP_Widget {

    /**
     * DMMContactUsLinksWidget Constructor
     *
     * @since DMM Contact Us Links Widget 1.0
     *
     */
    function __construct() {
        $widget_ops = array();
        $control_ops = array();
        parent::__construct(
            'DMMContactUsLinksWidget',
            __('Contact Us Links', 'lakeunion-theme'),
            $widget_ops,
            $control_ops
        );
    }

    /**
     * Prepare presentation layer
     *
     * @since DMM Contact Us Links Widget 1.0
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
            <address>
                <div>
                    <abbr title="Phone"><?php _e('Tel:', 'lakeunion-theme'); ?></abbr>
                    <a href="tel:<?php echo is_array($primary_location) && $primary_location['phone'] != '' ? $primary_location['phone'] : '(123) 456-7890' ?>"><?php echo is_array($primary_location) && $primary_location['phone'] != '' ? $primary_location['phone'] : '(123) 456-7890' ?></a>
                    <span>|</span>
                    <?php $pages = get_posts(array('post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-contact.php')); ?>
                    <a href='<?php echo "/{$pages[0]->post_name}" ?>'><?php _e('Contact Us', 'lakeunion-theme'); ?></a>
                </div>
            </address>
        <?php
        $output = ob_get_contents(); ///////////// Close buffer
        ob_end_clean(); ///////////// Clear buffer
        return $output;
    }

    /**
     * DOM elements for presentation
     *
     * @since DMM Contact Us Links Widget 1.0
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo $this->getPresentationLayer($args);
        echo $args['after_widget'];
    }

}
