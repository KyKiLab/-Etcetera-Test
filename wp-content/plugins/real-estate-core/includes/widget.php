<?php
/**
 * Real Estate Filter Widget
 */
if ( class_exists( 'WP_Widget' ) ) {
    class Real_Estate_Filter_Widget extends WP_Widget {
        public function __construct() {
            parent::__construct( 'real_estate_filter_widget', 'Real Estate Filter Widget' );
        }

        public function widget( $args, $instance ) {
            echo $args['before_widget'];
            echo do_shortcode('[real_estate_filter]');
            echo $args['after_widget'];
        }
    }

    add_action( 'widgets_init', function () {
        register_widget( 'Real_Estate_Filter_Widget' );
    });
}