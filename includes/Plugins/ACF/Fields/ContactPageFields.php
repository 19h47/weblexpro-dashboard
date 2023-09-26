<?php // phpcs:ignore
/**
 * Contact Page Fields
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF\Fields;

/**
 * Contact Page Fields
 */
class ContactPageFields {

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
		$key            = 'contact_page';
		$hide_on_screen = array();

		$location = array(
			array(
				array(
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'templates/contact.php',
				),
			),
		);

		$fields = array(
			array(
				'key'           => 'field_' . $key . '_form_id',
				'label'         => __( 'Form ID', 'weblexpro-dashboard' ),
				'name'          => 'form_id',
				'type'          => 'post_object',
				'post_type'     => array( 'wpcf7_contact_form' ),
				'post_status'   => '',
				'taxonomy'      => '',
				'return_format' => 'id',
				'multiple'      => 0,
				'allow_null'    => 0,
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'            => 'group_' . $key,
					'title'          => __( 'Contact Page Fields', 'weblexpro-dashboard' ),
					'fields'         => $fields,
					'location'       => $location,
					'hide_on_screen' => $hide_on_screen,
					'menu_order'     => 0,
				)
			);

		}
	}
}
