<?php
class DMMInventoryWidget extends WP_Widget {
    
    /**
     * DMMInventoryWidget Constructor
     */
    function __construct() {
        $widget_ops = array();
        $control_ops = array();
        parent::__construct(
            'DMMInventoryWidget',
            __('DMM Inventory Widget', 'plugin-inventory'),
            $widget_ops,
            $control_ops
        );
    }
    
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo '<!--[INVENTORY PLACEHOLDER]-->';
        echo $args['after_widget'];
    }    
}