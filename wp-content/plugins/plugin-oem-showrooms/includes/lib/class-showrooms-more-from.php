<?php
class Showrooms_More_From extends WP_Widget {
    
    /**
     * DMMShowroomsWidget Constructor
     */
    function __construct() {
        $widget_ops = array();
        $control_ops = array();
        parent::__construct(
            'Showrooms_More_From',
            __('Showrooms More From', 'plugin-inventory'),
            $widget_ops,
            $control_ops
        );
    }
    
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo '<!--[SHOWROOMS PLACEHOLDER]-->';
        echo $args['after_widget'];
    }    
}