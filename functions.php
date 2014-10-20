<?php
//* Do NOT include the opening php tag

//* Add Archive Settings option to Portolio CPT
add_post_type_support( 'portfolio', 'genesis-cpt-archives-settings' );

//* Define custom image size for Portfolio images in Portfolio archive
add_image_size( 'portfolio-image', 691, 460, true );

/**
 * Portfolio Template for Taxonomies
 * 
 */
function be_portfolio_template( $template ) {
  if( is_tax( array( 'portfolio_category', 'portfolio_tag' ) ) )
	$template = get_query_template( 'archive-portfolio' );
  return $template;
}
add_filter( 'template_include', 'be_portfolio_template' );

add_action( 'pre_get_posts', 'be_change_portfolio_posts_per_page' );
/**
 * Change Posts Per Page for Portfolio Archive
 * 
 * @author Bill Erickson
 * @link http://www.billerickson.net/customize-the-wordpress-query/
 * @param object $query data
 *
 */
function be_change_portfolio_posts_per_page( $query ) {
	
	if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'portfolio' ) ) {
		$query->set( 'posts_per_page', '10' );
	}

}
