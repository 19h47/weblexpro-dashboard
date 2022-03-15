<?php // phpcs:ignore
/**
 * BodyClass
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 * @since 0.0.0
 */

namespace WebLexProDashboard\PostTemplate;

/**
 * BodyClass
 *
 * @see https://developer.wordpress.org/reference/hooks/body_class/
 */
class BodyClass {

	/**
	 * Run default hooks and actions for WordPress
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'body_class', array( $this, 'body_classes' ), 10, 2 );
	}


	/**
	 * Filters the list of CSS body class names for the current post or page.
	 *
	 * @since 0.0.0
	 *
	 * @param string[] $classes An array of body class names.
	 * @param string[] $class   An array of additional class names added to the body.
	 *
	 * @return $classes array
	 */
	public function body_classes( array $classes, array $class ) : array {
		if ( is_front_page() ) {
			$classes[] = 'Front-page';
		}

		if ( is_home() ) {
			$classes[] = 'Home-page';
		}

		if ( is_singular( 'recipe' ) ) {
			$classes[] = 'Single-recipe';
		}

		if ( is_singular( 'post' ) ) {
			$classes[] = 'Single-post';
		}

		if ( is_singular( 'product' ) ) {
			$classes[] = 'Single-product';
		}

		if ( is_post_type_archive( 'leaf' ) ) {
			$classes[] = 'Archive-leaf';
		}

		if ( is_page_template( 'templates/find-us-page.php' ) ) {
			$classes[] = 'Find-us-page';
		}

		if ( is_page_template( 'templates/salad-creator-page.php' ) ) {
			$classes[] = 'Salad-creator-page';
		}

		return $classes;
	}
}
