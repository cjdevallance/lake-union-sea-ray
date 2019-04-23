<?php

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!');


class DMMSiteMapWidget extends WP_Widget {

    /**
     * DMMSiteMapWidget Constructor
     *
     * @since DMM Site Map Hours Widget 1.0
     *
     */
    function __construct() {
        $widget_ops = array();
        $control_ops = array();
        parent::__construct(
            'DMMSiteMapWidget',
            __('Sitemap', 'lakeunion-theme'),
            $widget_ops,
            $control_ops
        );
    }

    /**
     * Prepare presentation layer
     *
     * @since DMM Site Map Widget 1.0
     *
     */
    function getPresentationLayer($args) {

        global $wp;

        // overwrite default options
        $options = wp_parse_args( $args, $this->widget_options );

        ///////////// Open buffer
        ob_start();
        ?>
            <h3><?php _e('Site Map', 'lakeunion-theme'); ?></h3>
            <!-- Site Map -->
            <?php

            if (($locations = get_nav_menu_locations()) && isset($locations['essentialelite-footermenu'])) { ?>
                <ul class="list-groups">
                    <?php
                    $menu = wp_get_nav_menu_object($locations['essentialelite-footermenu']);
                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                    $index = 0;
                    foreach ($menu_items as $key => $menu_item) {
                        if ($menu_item->menu_item_parent != 0) continue;
                        if ($index > 0 && $index % 5 == 0) {
                            echo '</ul><ul class="list-groups">';
                        }
                        $index++; ?>
                        <li class="menu-item">
                            <a href="<?php echo $menu_item->url ?>"><?php echo $menu_item->title ?></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php
        $output = ob_get_contents(); ///////////// Close buffer
        ob_end_clean(); ///////////// Clear buffer
        return $output;
    }

    /**
     * DOM elements for presentation
     *
     * @since DMM Site Map Widget 1.0
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo $this->getPresentationLayer($args);
        echo $args['after_widget'];
    }

}
