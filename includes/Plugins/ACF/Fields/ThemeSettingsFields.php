<?php // phpcs:ignore
/**
 * Theme Settings Fields
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF\Fields;

/**
 * Theme Settings Fields
 */
class ThemeSettingsFields {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'acf/include_fields', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group.
	 *
	 * @return void
	 */
	public function fields() {
		$key            = 'theme_settings';
		$hide_on_screen = array();

		$location = array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'theme-settings',
				),
			),
		);

		$fields = array(
			array(
				'key'           => 'field_' . $key . '_case_studies',
				'label'         => __( 'Case Studies', 'dagobert' ),
				'name'          => 'case_studies',
				'type'          => 'relationship',
				'post_type'     => array( 'case_study' ),
				'filters'       => array( 'search' ),
				'return_format' => 'id',
				'elements'      => array( 'featured_image' ),
			),
			array(
				'key'        => 'fields_' . $key . '_footer',
				'name'       => 'footer',
				'label'      => __( 'Footer', 'dagobert' ),
				'type'       => 'group',
				'sub_fields' => array(
					array(
						'key'           => 'field_' . $key . '_footer_stickers',
						'label'         => __( 'Stickers', 'dagobert' ),
						'name'          => 'stickers',
						'type'          => 'gallery',
						'return_format' => 'id',
						'library'       => 'all',
						'insert'        => 'append',
						'preview_size'  => 'medium',
					),
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'            => 'group_' . $key,
					'title'          => __( 'Theme Settings Fields', 'dagobert' ),
					'fields'         => $fields,
					'location'       => $location,
					'hide_on_screen' => $hide_on_screen,
					'menu_order'     => 0,
				)
			);

		}
	}
}
