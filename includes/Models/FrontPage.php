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
		$args = array(
			'echo'     => false,
			'redirect' => get_permalink(),
		);

		return wp_login_form( $args );
	}
}
