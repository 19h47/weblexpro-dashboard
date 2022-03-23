<?php // phpcs:ignore
/**
 * Front Page
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Models;

use Timber\{ Timber, Post };

/**
 * Class Front Page
 */
class FrontPage extends Post {
	/**
	 * Current User
	 */
	public function current_user() {
		return wp_get_current_user();
	}

	public function login_form() {
		$data = TImber::context();

		$data = array_merge(
			$data,
			array(
				'redirect'         => get_permalink(),
				'action'           => site_url( 'wp-login.php', 'login_post' ),
				'lostpassword_url' => wp_lostpassword_url(),
			)
		);

		return Timber::compile( 'components/form-login.html.twig', $data );
	}

	public function lostpassword_url() {
		return wp_lostpassword_url();
	}
}
