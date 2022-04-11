<?php // phpcs:ignore
/**
 * General Template
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard;

/**
 * General Template
 */
class TemplateLoader {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
	}

	/**
	 * Template Redirect
	 */
	public function template_redirect() {
		global $post;

		if ( $post && 'templates/dashboard.php' === get_post_meta( $post->ID, '_wp_page_template', true ) && ! is_user_logged_in() ) {
			wp_redirect( home_url() );
			exit();
		}

		if ( is_singular( 'document' ) && ! is_user_logged_in() ) {
			wp_redirect( home_url() );
			exit();
		}

		if ( is_tax( 'document_category' ) && ! is_user_logged_in() ) {
			wp_redirect( home_url() );
			exit();
		}
	}
}
