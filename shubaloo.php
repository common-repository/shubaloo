<?php
/*
Plugin Name: Shubaloo
Plugin URI: https://wordpress.org/plugins/shubaloo/
Description: Curate and embed an interactive concert calendar.
Version: 1.0
Author: Shu Zhang
Author URI: https://profiles.wordpress.org/shuisonfire
License: GPL2
*/

class Shubaloo_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'shubaloo_widget', // Base ID
			__( 'Shubaloo', 'text_domain' ), // Name
			array( 'description' => __( 'An embedded concert calendar and music player. Choose a city or pick the specific shows you want to feature at http://shubaloo.com', 'text_domain' ), ) // Args
		);
	}

	// widget form creation
	function form($instance) {
        // Check values
        if( $instance) {
             $title = esc_attr($instance['title']);
             $user = esc_attr($instance['user']);
             $city = esc_attr($instance['city']);
             $width = esc_attr($instance['width']);;
             $height = esc_attr($instance['height']);;
        } else {
             $title = 'Vancouver Shows';
             $user = '';
             $city = 'Vancouver BC';
             $width = '320';
             $height = '480';
        }
        ?>

        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('user'); ?>"><?php _e('Shubaloo User Id:', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo $user; ?>" />
        (if you want to feature your own concert picks)
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('city'); ?>"><?php _e('City:', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('city'); ?>" name="<?php echo $this->get_field_name('city'); ?>" type="text" value="<?php echo $city; ?>"/>
        (if you want to feature all shows in a city)
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
        </p>

        <?php
    }

	// widget update
	function update($new_instance, $old_instance) {
		      $instance = $old_instance;
              // Fields
              $instance['title'] = strip_tags($new_instance['title']);
              $instance['user'] = strip_tags($new_instance['user']);
              $instance['city'] = strip_tags($new_instance['city']);
              $instance['width'] = strip_tags($new_instance['width']);
              $instance['height'] = strip_tags($new_instance['height']);
             return $instance;
	}

	// widget display
	function widget($args, $instance) {
		extract( $args );
           // these are the widget options
           $title = apply_filters('widget_title', $instance['title']);
           $user = $instance['user'];
           $city = $instance['city'];
           $width = $instance['width'];
           $height = $instance['height'];

           echo $before_widget;
           // Display the widget
           echo '<div class="widget-text wp_widget_plugin_box">';

           // Check if title is set
           if ( $title ) {
              echo $before_title . $title . $after_title;
           }

           $shubalooPath = "//shubaloo.com/widget/";
           if ( $user ) {
             $shubalooPath = $shubalooPath . "user=$user";
           } else if ( $city ) {
             $shubalooPath = $shubalooPath . "city=$city";
           }

           echo '<iframe style="border: 0; width: ' . $width . 'px; height: ' . $height . 'px;" src="' . $shubalooPath . '"></iframe>';
           echo 'Powered by <a href="//shubaloo.com">Shubaloo</a>';

           echo '</div>';
           echo $after_widget;
	}
}

// register widget
function register_shubaloo_widget() {
    register_widget( 'Shubaloo_Widget' );
}
add_action( 'widgets_init', 'register_shubaloo_widget' );?>
