<?php // phpcs:ignore
/**
 * Settings
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Setup;

/**
 * Supports
 */
class Settings {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}


	/**
	 * Register settings
	 *
	 * @return void
	 */
	public function register_settings() : void {
		add_settings_field(
			'page_dashboard',
			__( 'Dashboard', 'weblexprodashboard' ),
			array( $this, 'dashboard_page_callback' ),
			'reading',
			'default',
			array()
		);

		register_setting( 'reading', 'page_dashboard' );
	}


	/**
	 * Dashboard Page
	 */
	public function dashboard_page_callback() : void {
		wp_dropdown_pages(
			array(
				'name'              => 'page_dashboard',
				'show_option_none'  => __( '&mdash; Select &mdash;', 'weblexprodashboard' ),
				'option_none_value' => '0',
				'selected'          => get_option( 'page_dashboard' ),
			)
		);
	}
}
