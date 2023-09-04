<?php // phpcs:ignore
/**
 * Member Offer Fields
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF\Fields;

/**
 * Member Offer Fields
 */
class OfferPostFields {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'acf/init', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group.
	 *
	 * @return void
	 */
	public function fields() {
		$key            = 'offer_post';
		$hide_on_screen = array();

		$location = array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'offer',
				),
			),
		);

		$fields = array(
			array(
				'key'           => 'field_' . $key . '_color',
				'label'         => __( 'Color', 'weblexprodashboard' ),
				'name'          => 'color',
				'type'          => 'color_picker',
				'default_value' => '#ffffff',
			),
			array(
				'key'         => 'field_' . $key . '_catchphrase',
				'label'       => __( 'Catchphrase', 'weblexprodashboard' ),
				'name'        => 'catchphrase',
				'type'        => 'text',
				'placeholder' => __( 'catchphrase', 'weblexprodashboard' ),
			),
			array(
				'key'         => 'field_' . $key . '_description',
				'label'       => __( 'Description', 'weblexprodashboard' ),
				'name'        => 'description',
				'type'        => 'textarea',
				'rows'        => 4,
				'new_lines'   => 'br',
				'placeholder' => __( 'Description', 'weblexprodashboard' ),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'            => 'group_' . $key,
					'title'          => __( 'Offer Post Fields', 'weblexprodashboard' ),
					'fields'         => $fields,
					'location'       => $location,
					'hide_on_screen' => $hide_on_screen,
					'menu_order'     => 0,
				)
			);

		}
	}
}
