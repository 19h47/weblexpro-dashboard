<?php // phpcs:ignore
/**
 * Page
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Models;

use Timber\{ Timber, Post };

/**
 * Class Front Page
 */
class Page extends Post {

	/**
	 * Login Form
	 */
	public function login_form() {
		$data = TImber::context();

		$data = array_merge(
			$data,
			array(
				'redirect'         => get_permalink( get_option( 'page_dashboard' ) ),
				'action'           => site_url( 'wp-login.php', 'login_post' ),
				'lostpassword_url' => wp_lostpassword_url(),
			)
		);

		return Timber::compile( 'components/form-login.html.twig', $data );
	}


	/**
	 * Post Login Form
	 */
	public function post_login_form() {
		$data = TImber::context();

		$data = array_merge(
			$data,
			array(
				'redirect'         => get_permalink(),
				'action'           => site_url( 'wp-login.php?action=postpass', 'login_post' ),
				'lostpassword_url' => wp_lostpassword_url(),
			)
		);

		return Timber::compile( 'components/form-login-post.html.twig', $data );
	}

	/**
	 * Loaspassword url
	 */
	public function lostpassword_url() {
		return wp_lostpassword_url();
	}
}
