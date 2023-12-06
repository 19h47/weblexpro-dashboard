<?php // phpcs:ignore
/**
 * Loader
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Template;

/**
 * Loader
 */
class Loader {


	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
	}

	/**
	 * Template Redirect
	 */
	public function template_redirect() {
		global $post;

		if ( $post && 'templates/contact.php' === get_post_meta( $post->ID, '_wp_page_template', true ) && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit();
		}

		if ( $post && 'templates/dashboard.php' === get_post_meta( $post->ID, '_wp_page_template', true ) && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit();
		}

		if ( $post && 'templates/documents.php' === get_post_meta( $post->ID, '_wp_page_template', true ) && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit();
		}

		if ( $post && 'templates/likes.php' === get_post_meta( $post->ID, '_wp_page_template', true ) && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit();
		}

		if ( $post && 'templates/practical-sheets.php' === get_post_meta( $post->ID, '_wp_page_template', true ) && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit();
		}

		if ( is_singular( 'offer' ) && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit();
		}

		if ( is_singular( 'document' ) && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit();
		}

		if ( is_tax() && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit();
		}

		if ( is_page() && ! is_front_page() && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit();
		}
	}
}
