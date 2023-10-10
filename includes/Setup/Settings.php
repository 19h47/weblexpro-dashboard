<?php // phpcs:ignore
/**
 * Settings
 *
 * @package    WordPress
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
	public function run(): void {
		add_action( 'admin_init', array( $this, 'settings_api_init' ) );
		add_action( 'init', array( $this, 'register_settings' ) );
	}


	/**
	 * Register settings
	 *
	 * @return void
	 */
	public function settings_api_init(): void {
		add_settings_section(
			'contacts',
			'',
			array( $this, 'contacts_callback_function' ),
			'reading'
		);

		add_settings_field(
			'public_email',
			__( 'Public Email Address', 'weblexpro-dashboard' ),
			array( $this, 'email_callback_function' ),
			'reading',
			'contacts',
			array(
				'name'        => 'public_email',
				'label'       => __( 'Email', 'weblexpro-dashboard' ),
				'description' => __( 'This address is used for public purposes.', 'weblexpro-dashboard' ),
				'placeholder' => 'artvandelay@vandelayindustries.com',
			)
		);

		add_settings_field(
			'phone_number',
			__( 'Phone Number', 'weblexpro-dashboard' ),
			array( $this, 'text_callback_function' ),
			'reading',
			'contacts',
			array(
				'name'        => 'phone_number',
				'label'       => __( 'Phone Number', 'weblexpro-dashboard' ),
				'placeholder' => '+353 87 222 0720',
				'description' => __( 'This phone number is used for public purposes.', 'weblexpro-dashboard' ),
			)
		);

		add_settings_section(
			'socials',
			'',
			array( $this, 'socials_callback_function' ),
			'general'
		);

		add_settings_field(
			'facebook',
			__( 'Facebook', 'weblexpro-dashboard' ),
			array( $this, 'url_callback_function' ),
			'general',
			'socials',
			array(
				'name'        => 'facebook',
				'placeholder' => 'https://www.facebook.com/artvandelay',
				'description' => __( 'Enter the Facebook URL here.', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'instagram',
			__( 'Instagram', 'weblexpro-dashboard' ),
			array( $this, 'url_callback_function' ),
			'general',
			'socials',
			array(
				'name'        => 'instagram',
				'placeholder' => 'https://instagram.com/artvandelay',
				'description' => __( 'Enter the Instagram URL here.', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'youtube',
			__( 'YouTube', 'weblexpro-dashboard' ),
			array( $this, 'url_callback_function' ),
			'general',
			'socials',
			array(
				'name'        => 'youtube',
				'placeholder' => 'https://youtube.com/artvandelay',
				'description' => __( 'Enter the YouTube URL here.', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'twitter',
			__( 'Twitter', 'weblexpro-dashboard' ),
			array( $this, 'url_callback_function' ),
			'general',
			'socials',
			array(
				'name'        => 'twitter',
				'placeholder' => 'https://www.twitter.com/artvandelay',
				'description' => __( 'Enter the Twitter URL here.', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'linkedin',
			__( 'LinkedIn', 'weblexpro-dashboard' ),
			array( $this, 'url_callback_function' ),
			'general',
			'socials',
			array(
				'name'        => 'linkedin',
				'placeholder' => 'https://www.linkedin.com/artvandelay',
				'description' => __( 'Enter the LinkedIn URL here.', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'notice',
			__( 'Notice', 'weblexpro-dashboard' ),
			array( $this, 'text_callback_function' ),
			'reading',
			'default',
			array(
				'id'          => 'notice',
				'name'        => 'notice',
				'value'       => get_option( 'notice' ),
				'placeholder' => __( 'Notice', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'page_dashboard',
			__( 'Dashboard', 'weblexpro-dashboard' ),
			array( $this, 'dropdown_pages_callback_function' ),
			'reading',
			'default',
			array(
				'name'        => 'page_dashboard',
				'description' => __( 'Page Dashboard', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'page_likes',
			__( 'Likes', 'weblexpro-dashboard' ),
			array( $this, 'dropdown_pages_callback_function' ),
			'reading',
			'default',
			array(
				'name'        => 'page_likes',
				'description' => __( 'Page Likes', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'page_documents',
			__( 'Documents', 'weblexpro-dashboard' ),
			array( $this, 'dropdown_pages_callback_function' ),
			'reading',
			'default',
			array(
				'name'        => 'page_documents',
				'description' => __( 'Page Documents', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'page_contact',
			__( 'Contact', 'weblexpro-dashboard' ),
			array( $this, 'dropdown_pages_callback_function' ),
			'reading',
			'default',
			array(
				'name'        => 'page_contact',
				'description' => __( 'Page Contact', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'page_practical_sheets',
			__( 'Practical Sheets', 'weblexpro-dashboard' ),
			array( $this, 'dropdown_pages_callback_function' ),
			'reading',
			'default',
			array(
				'name'        => 'page_practical_sheets',
				'description' => __( 'Page Practical Sheets', 'weblexpro-dashboard' ),
			)
		);

		add_settings_field(
			'url_weblexpro_contact',
			__( 'WebLexPro Contact Page', 'weblexpro-dashboard' ),
			array( $this, 'url_callback_function' ),
			'reading',
			'default',
			array(
				'name'        => 'url_weblexpro_contact',
				'placeholder' => 'https://vandelayindustries.com/contact',
				'description' => __( 'WebLexPro Contact Page', 'weblexpro-dashboard' ),
			)
		);
	}


	/**
	 * Socials callback function
	 *
	 * @return void
	 */
	public function socials_callback_function(): void {
		echo '';
	}


	/**
	 * Contacts callback function
	 *
	 * @return void
	 */
	public function contacts_callback_function(): void {
		echo '';
	}


	/**
	 * Dropdown pages callback function
	 *
	 * @param array $args Arguments.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_dropdown_pages/
	 *
	 * @return void
	 */
	public function dropdown_pages_callback_function( array $args ): void {
		wp_dropdown_pages(
			array(
				'selected' => get_option( $args['name'] ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'name'         => $args['name'], // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			)
		);

		if ( $args['description'] ) {
			echo wp_kses_post( '<p class="description">' . $args['description'] . '</p>' );
		}
	}


	/**
	 * Text callback function
	 *
	 * @param array $args Args.
	 *
	 * @return void
	 */
	public function text_callback_function( array $args ): void {
		wp_form_controls_input(
			array(
				'type'        => isset( $args['type'] ) && ! empty( $args['type'] ) ? $args['type'] : 'text',
				'name'        => $args['name'],
				'value'       => get_option( $args['name'] ),
				'placeholder' => $args['placeholder'],
				'description' => isset( $args['description'] ) && ! empty( $args['description'] ) ? $args['description'] : $args['placeholder'],
			),
		);
	}


	/**
	 * Email callback function
	 *
	 * @param array $args Args.
	 *
	 * @return void
	 */
	public function email_callback_function( $args ): void {
		wp_form_controls_input(
			array(
				'type'        => 'email',
				'name'        => $args['name'],
				'value'       => get_option( $args['name'] ),
				'placeholder' => $args['placeholder'],
				'description' => $args['description'],
				'attributes'  => array(
					'pattern'      => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$',
					'autocomplete' => 'email',
					'aria-label'   => $args['label'],
				),
			)
		);
	}


	/**
	 * URL callback function
	 *
	 * @param array $args Args.
	 *
	 * @return void
	 */
	public function url_callback_function( $args ): void {
		wp_form_controls_input(
			array(
				'type'        => 'url',
				'name'        => $args['name'],
				'value'       => get_option( $args['name'] ),
				'placeholder' => $args['placeholder'],
				'description' => $args['description'],
			)
		);
	}


	/**
	 * Textarea callback function
	 *
	 * @param array $args Arguments.
	 *
	 * @see    https://core.trac.wordpress.org/browser/tags/5.6/src/wp-includes/post-template.php#L1163
	 * @return void
	 */
	public function textarea_callback_function( array $args ): void {
		wp_form_controls_textarea( $args );
	}


	/**
	 * Register settings
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_setting/
	 *
	 * @return void
	 */
	public function register_settings(): void {
		$args = array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => null,
		);

		foreach ( array( 'facebook', 'instagram', 'youtube', 'twitter', 'linkedin' ) as $setting ) {
			register_setting( 'general', $setting, $args );
		}

		register_setting( 'reading', 'public_email' );
		register_setting( 'reading', 'phone_number' );
		register_setting( 'reading', 'address' );
		register_setting( 'reading', 'notice' );
		register_setting( 'reading', 'page_dashboard' );
		register_setting( 'reading', 'page_contact' );
		register_setting( 'reading', 'page_likes' );
		register_setting( 'reading', 'page_documents' );
		register_setting( 'reading', 'page_practical_sheets' );
		register_setting( 'reading', 'url_weblexpro_contact' );
	}
}
