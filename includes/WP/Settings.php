<?php // phpcs:ignore
/**
 * Settings
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\WP;

/**
 * Settings
 */
class Settings {


	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
	}

	function after_setup_theme() {
		if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
			show_admin_bar( false );
		}
	}
}
