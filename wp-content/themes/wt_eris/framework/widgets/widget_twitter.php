<?php
/*
 * Plugin Name: Well Themes: Latest Tweets
 * Plugin URI: http://wellthemes.com/
 * Description: A widget to display latest tweets in the sidebar or footer of the theme.
 * Version: 1.0
 * Author: Well Themes Team
 * Author URI: http://wellthemes.com/
 */

 /**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'wellthemes_twitter_widgets' );

function wellthemes_twitter_widgets() {
	register_widget( 'wellthemes_twitter_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class wellthemes_twitter_widget extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function wellthemes_twitter_widget() {
		/* Widget settings */
		$widget_ops = array( 'classname' => 'widget_tweets', 'description' => __('A widget to display latest tweets in the sidebar or footer.', 'wellthemes') );

		/* Create the widget */
		$this->WP_Widget( 'wellthemes_twitter_widget', __('Well Themes: Latest Tweets', 'wellthemes'), $widget_ops );
	}
	
	/**
	 * display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		
		echo $before_widget;
		
		if ( $title )
		echo $before_title . $title . $after_title;
		
		?>
		
		<script type="text/javascript" src="http://widgets.twimg.com/j/2/widget.js"></script>
		<script type="text/javascript">
			new TWTR.Widget({
				version: 2,
				type: 'profile',
				rpp: 10,
				interval: 6000,
				width: 'auto',
				height: 200,
				theme: {
					shell: {
						background: 'none',
						color: '#676767',
						links: '#464646'
					},
					tweets: {
						background: 'none',
						color: '#676767',
						links: '#464646'
					}
				},
				features: {
					scrollbar: false,
					loop: true,
					live: true,
					hashtags: false,
					timestamp: false,
					avatars: false,
					behavior: 'default'
				}
			}).render().setUser('<?php echo $instance['username']; ?>').start();
		</script>            
    <?php
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = $new_instance['username'];		
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	 function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Latest Tweets',
		'username' => ''		
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wellthemes') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter username:', 'wellthemes') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>
		
	<?php
	}
}

?>