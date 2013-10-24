<?php
/*
Plugin Name: Shortcode Plugin
Plugin URI: 
Description: This is not just a plugin, its a useless plugin
Author: Matt Keehner
Version: 0.1
Author URI: 
*/

class Shortcode_Plugin {
	/**
	 *
	 */
	public function __construct() {
		add_shortcode( 'display_posts', array( $this, 'output_shortcode' ) );
		add_action( 'init', array( $this, 'output_shortcode_button' ) );
	}

	/**
	 *
	 */
	public function output_shortcode( $atts, $content = null ) {
		// The $defaults hold all of the possible options
		$defaults = array(
			'posts_per_page' => 4,
			'post_type'      => 'post',
		);
		// The shortcode_atts function will compare and set defaults
		// The 3rd field is new in 3.6 and it is a filter to modify the atts
		// extract will create variables out of the $key = value pairs
		extract( shortcode_atts( $defaults, $atts, 'shortcode_plugin' ), EXTR_SKIP );

		// The args for our query will be set by the options from the extract
		$args = array( 
			'post_type'      => $post_type,
			'posts_per_page' => $posts_per_page,
		);

		// Create a new query
		$query = new WP_Query( $args );

		// Crete an output buffer because shortcodes cannot echo
		ob_start();
		// Execute the loop and output relevant information
		while( $query->have_posts() ) : $query->the_post(); ?>
			<div class="post-container">
				<header class="post-header">
					<?php the_title(); ?>
				</header>
				<div class="post-excerpt">
					<?php the_excerpt(); ?>
				</div>
			</div>
		<?php
		endwhile;

		// Gather the output buffer in a variable
		$output = ob_get_contents();
		// Clear output buffer
		ob_end_clean();
		// Reset the loop for WordPress
		wp_reset_postdata();

		// Return our shortcode
		return $output;
	}

	/**
	 *
	 */
	public function output_shortcode_button() {
		add_filter( 'mce_external_plugins', array( $this, 'add_buttons' ) );
		add_filter( 'mce_buttons', array( $this, 'register_buttons' ) );
	}

	/**
	 *
	 */
	public function add_buttons( $plugin_array ) {
		$plugin_array['display_posts'] = plugins_url( '/js/display-posts.js', __FILE__ );
		return $plugin_array;
	}
	/**
	 *
	 */
	public function register_buttons( $buttons ) {
		// The ID value of the button we are creating
		array_push( $buttons, 'display_posts' );
		return $buttons;
	}
}
new Shortcode_Plugin();