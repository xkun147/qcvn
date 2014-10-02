<?php 

add_action('widgets_init','mom_widget_login');

function mom_widget_login() {
	register_widget('mom_widget_login');
	
	}

class mom_widget_login extends WP_Widget {
	function mom_widget_login() {
			
		$widget_ops = array('classname' => 'momizat-login','description' => __('Widget display Login form','theme'));
		$this->WP_Widget('momizatLogin',__('Momizat - Login form','theme'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
                        $redirect = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        ?>
                        
                        <div class="mom-login-widget">
                            <?php if ( !is_user_logged_in() ) { ?>
                            <form class="mom-login-form" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post') ) ?>" method="post">
					<div class="mom-username">
						<input type="text" name="log" value="" placeholder="<?php _e('username', 'theme'); ?>">
					</div>

					<div class="mom-password">
						<input type="password" name="pwd" value="" placeholder="<?php _e('password', 'theme'); ?>">
					</div>

					<div class="mom-submit-wrapper">
						<button class="button submit user-submit" name="user-submit" type="submit"><?php _e('Log In', 'theme'); ?></button>
						<input type="checkbox" id="rememberme" name="rememberme" value="forever" <?php checked( 'rememberme', 1 ); ?>>
						<label for="rememberme"><i class="dashicons dashicons-yes"></i><?php _e('Remember Me', 'theme'); ?></label>
                                                <input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect ); ?>" />
					</div>
                            </form>
                            <?php
                            
                            } else { ?>
				<?php
					$current_user = wp_get_current_user();
					$id = get_current_user_id();
					$name = $current_user->display_name;
				?>
                                <?php echo get_avatar( $id, 60 ); ?>
				<div class="lw-user-info">
					<a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>"><?php _e('Howdy', 'theme'); ?>, <strong><?php echo $name; ?></strong></a>
					<a href=" <?php echo get_edit_profile_url($id); ?> " class="button"><?php _e('Edit My profile', 'theme'); ?></a>
					<a href="<?php echo wp_logout_url(); ?>" class="button"><?php _e('Log Out', 'theme'); ?></a>
				</div>
				
                            
                            <?php } ?>
			    <div class="clear"></div>
                        </div>
                        <?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
	
		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => __('Login', 'theme')
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
	
		?>
	
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','theme'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>
   <?php 
}
	} //end class