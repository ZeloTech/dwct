<?php
/**
 * Theme Junkie Feedburner Widget
 */
 
class TJ_Widget_Feedburner extends WP_Widget {

	function TJ_Widget_Feedburner() {
		$widget_ops = array('classname' => 'widget_feedburner', 'description' => __('Feedburner Email Subscription Box'));
		$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('feedburner', __('ThemeJunkie - Feedburner'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$feedburner_id = $instance['feedburner_id'];
		?>

	<div id="newsletter-widget" class="widget">
	
	<div class="newsletter clearfix">	
	 <h3 class="widget-title"><?php _e('Get coupons in your email box', 'themejunkie'); ?></h3>
	 <p><?php _e('Complete the form below, and we\'ll send you the best coupons.', 'themejunkie'); ?></p>
	 
	 		<form class="newsletter-form" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburner_id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<input class="email" type="text" name="email" placeholder="mail@yourwebsite.com"/>

				<input type="hidden" value="<?php echo $feedburner_id; ?>" name="uri"/>
				<input type="hidden" value="<?php echo $feedburner_id; ?>" name="title"/>
				<input type="hidden" name="loc" value="en_US"/>
				<input class="submit" type="submit" name="submit" value="Signup" /> <span class="feedburner-text">Deliver via <a href="http://feedburner.google.com/" target="_blank">FeedBurner</a></span>
			</form>
		</div>			
	</div><!-- #newsletter-widget -->

		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['feedburner_id'] = $new_instance['feedburner_id'];
		return $instance;
	}

	function form( $instance ) { 
		$instance = wp_parse_args( (array) $instance, array( 'feedburner_id' => 'themejunkie' ) );
		$feedburner_id = $instance['feedburner_id'];
	?>
		<p><label for="<?php echo $this->get_field_id('feedburner_id'); ?>"><?php _e('Enter your Feedburner ID:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('feedburner_id'); ?>" name="<?php echo $this->get_field_name('feedburner_id'); ?>" type="text" value="<?php echo $feedburner_id; ?>" /></p>
		<?php }
}

register_widget('TJ_Widget_Feedburner');

