<?php

/**
 * Enqueue child styles.
 */
function child_enqueue_styles()
{
	wp_enqueue_style('child-theme', get_stylesheet_directory_uri() . '/style.css', array(), 100);
}

// add_action( 'wp_enqueue_scripts', 'child_enqueue_styles' ); // Remove the // from the beginning of this line if you want the child theme style.css file to load on the front end of your site.

/**
 * Add custom functions here
 */
if (!function_exists('inspry_year_shortcode_handler')) {
	function inspry_year_shortcode_handler()
	{
		return date('Y');
	}
}
add_shortcode('year', 'inspry_year_shortcode_handler');

add_filter('the_content', 'force_br_paragraph_tags_for_page', 20);
function force_br_paragraph_tags_for_page($content) {
    // Check if it's the specific page or the archive page for the post type
    if (is_page(2331)) {
        // Apply wpautop only for the specific page or post type archive
        $content = wpautop($content);
    }
    return $content;
}
