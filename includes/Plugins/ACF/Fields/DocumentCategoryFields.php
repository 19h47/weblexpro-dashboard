<?php // phpcs:ignore
/**
 * Document Category Fields
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF\Fields;

/**
 * Document Category Fields
 */
class DocumentCategoryFields {
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
		$key            = 'document_category';
		$hide_on_screen = array();

		$location = array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'document_category',
				),
			),
		);

		$fields = array(
			array(
				'key'           => 'field_' . $key . '_image',
				'label'         => __( 'Image', 'weblexpro-dashboard' ),
				'name'          => 'image',
				'type'          => 'image',
				'return_format' => 'array',
				'library'       => 'all',
				'preview_size'  => 'full',
			),
			array(
				'key'           => 'field_' . $key . '_offer_type',
				'label'         => __( 'Type', 'weblexpro-dashboard' ),
				'name'          => 'type',
				'type'          => 'radio',
				'required'      => 1,
				'choices'       => array(
					'event'  => __( 'Event', 'weblexpro-dashboard' ),
					'birdie' => __( 'Birdie', 'weblexpro-dashboard' ),
					'eagle'  => __( 'Eagle', 'weblexpro-dashboard' ),
					'mag'    => __( 'Mag', 'weblexpro-dashboard' ),
				),
				'return_format' => 'value',
				'allow_null'    => 0,
				'other_choice'  => 0,
				'layout'        => 'horizontal',
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'            => 'group_' . $key,
					'title'          => __( 'Document Category Fields', 'weblexpro-dashboard' ),
					'fields'         => $fields,
					'location'       => $location,
					'hide_on_screen' => $hide_on_screen,
					'menu_order'     => 0,
				)
			);

		}
	}
}
