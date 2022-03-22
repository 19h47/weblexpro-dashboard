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
			'copyright',
			__( 'Copyright', 'weblexprodashboard' ),
			array( $this, 'textarea_callback' ),
			'reading',
			'default',
			array(
				'id'          => 'copyright',
				'name'        => 'copyright',
				'value'       => get_option( 'copyright' ),
				'placeholder' => __( 'Copyright', 'weblexprodashboard' ),
			)
		);

		register_setting( 'reading', 'copyright' );
	}


	/**
	 * Description callback
	 *
	 * @param array $args Arguments.
	 *
	 * @see https://core.trac.wordpress.org/browser/tags/5.6/src/wp-includes/post-template.php#L1163
	 * @return void
	 */
	public function textarea_callback( array $args ) : void {
		wp_form_controls_textarea( $args );
	}
}
