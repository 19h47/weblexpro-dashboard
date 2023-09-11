<?php // phpcs:ignore
/**
 * Class User
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Post;

/**
 * User class
 */
class User {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'wp_ajax_like_document', array( $this, 'like_document' ) );
		add_action( 'wp_ajax_nopriv_like_document', array( $this, 'like_document' ) );
	}


	/**
	 * Like Document
	 */
	public function like_document() {
		if ( ! isset( $_GET['nonce'] ) && ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'security' ) ) {
			return false;
		}

		$post_id = (int) $_GET['postId']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$user_id = (int) $_GET['userId']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		$likes = get_field( 'likes', "user_{$user_id}" );

		$search = array_search( $post_id, $likes, true );

		if ( false !== $search ) {
			unset( $likes[ $search ] );
		} else {
			$likes[] = $post_id;
		}

		update_field( 'likes', $likes, "user_{$user_id}" );

		wp_send_json(
			array(
				'likes' => $likes,
			)
		);

		wp_die();
	}
}
