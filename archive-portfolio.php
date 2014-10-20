<?php
/**
 * Portfolio Archive
 * Author: Sridhar Katakam
 *
 */

//* Add portfolio body class to the head
add_filter( 'body_class', 'sk_add_portfolio_body_class' );
function sk_add_portfolio_body_class( $classes ) {
   $classes[] = 'beautiful-pro-portfolio';
   return $classes;
}

//* Enqueue Script
add_action( 'wp_enqueue_scripts', 'load_portfolio_script' );
function load_portfolio_script() {

	wp_enqueue_script( 'portfolio-archive', get_stylesheet_directory_uri() .'/js/portfolio-archive.js' , array( 'jquery' ), '1.0.0', true );

}

//* Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/**
 * Display as Columns
 *
 */
function be_portfolio_post_class( $classes ) {
	
	global $wp_query;
	if( !$wp_query->is_main_query() ) 
		return $classes;
		
	$columns = 3;
	
	$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
	$classes[] = $column_classes[$columns];
	if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns )
		$classes[] = 'first';
		
	return $classes;
}
add_filter( 'post_class', 'be_portfolio_post_class' );

//* Remove items from loop
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Do not show Featured image if set in Theme Settings > Content Archives
add_filter( 'genesis_pre_get_option_content_archive_thumbnail', '__return_false' );

add_action( 'genesis_entry_header', 'be_portfolio_image', 4 );
/**
 * Add Portfolio Image
 *
 */
function be_portfolio_image() {
	echo '<a href="' . get_permalink() . '">' . genesis_get_image( array( 'size' => 'portfolio-image' ) ). '</a>';
}

//* Force Excerpts
add_filter( 'genesis_pre_get_option_content_archive', 'sk_show_excerpts' );
function sk_show_excerpts() {
	return 'excerpts';
}

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'sp_excerpt_length' );
function sp_excerpt_length( $length ) {
	return 10; // pull first 10 words
}

//* Modify the Excerpt read more link
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '">More</a>';
}

//* Wrap .entry-header and .entry-content in a custom div - opening
add_action( 'genesis_entry_header', 'sk_opening_div', 4 );
function sk_opening_div() {
	echo '<div class="entry-content-wrap">';
}

//* Wrap .entry-header and .entry-content in a custom div - closing
add_action( 'genesis_entry_footer', 'sk_closing_div' );
function sk_closing_div() {
	echo '</div>';
}

//* Wrap all entries in a custom div - opening
add_action( 'genesis_before_loop', 'portfolio_entries_opening' );
function portfolio_entries_opening() {
	echo '<div class="portfolio-entries">';
}

//* Wrap all entries in a custom div - closing
add_action( 'genesis_after_loop', 'portfolio_entries_closing' );
function portfolio_entries_closing() {
	echo '</div>';
}

genesis();
