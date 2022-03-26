<?php // phpcs:ignore
/**
 * Post States
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Template;

use WP_Post;

/**
 * PostStates
 */
class PostStates {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'display_post_states', array( $this, 'filter_post_states' ), 10, 2 );
	}

	/**
	 * Post states
	 *
	 * @param string[] $post_states An array of post display states.
	 * @param WP_Post  $post        The current post object.
	 *
	 * @return array $states
	 */
	public function filter_post_states( array $post_states, WP_Post $post ) {
		if ( 'templates/dashboard.php' === get_post_meta( $post->ID, '_wp_page_template', true ) ) {
			$post_states[] = __( 'Dashboard Page', 'weblexprodashboard' );
		}

		return $post_states;
	}
}
