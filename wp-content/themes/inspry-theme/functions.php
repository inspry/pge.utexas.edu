<?php

if (!function_exists('inspry_year_shortcode_handler')) {
    /**
     * Handles shortcode that displays the year.
     * 
     * Usage: `[year]`.
     * 
     * @return string Shortcode markup.
     */
	function inspry_year_shortcode_handler()
	{
		return date('Y');
	}
    add_shortcode('year', 'inspry_year_shortcode_handler');
}

if (!function_exists('force_br_paragraph_tags_for_page')) {
    /**
     * Runs `wpautop` on content for specific pages.
     * 
     * @return string Modified content.
     */
    function force_br_paragraph_tags_for_page($content) {
        // Check if it's the specific page or the archive page for the post type
        if (is_page(2331)) {
            // Apply wpautop only for the specific page or post type archive
            $content = wpautop($content);
        }

        return $content;
    }
    add_filter('the_content', 'force_br_paragraph_tags_for_page', 20);
}

// Test
