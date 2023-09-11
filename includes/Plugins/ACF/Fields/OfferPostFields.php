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
		add_action( 'acf/include_fields', array( $this, 'fields' ) );
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
				'key'           => 'field_' . $key . '_type',
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
			array(
				'key'               => 'field_' . $key . '_documents',
				'label'             => __( 'Documents', 'weblexpro-dashboard' ),
				'name'              => 'documents',
				'type'              => 'taxonomy',
				'instructions'      => __( 'Indicate the document categories related to the offer.', 'weblexpro-dashboard' ),
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_' . $key . '_type',
							'operator' => '==',
							'value'    => 'event',
						),
					),
				),
				'taxonomy'          => 'document_category',
				'add_term'          => 0,
				'save_terms'        => 0,
				'load_terms'        => 0,
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
			),
			array(
				'key'           => 'field_' . $key . '_color',
				'label'         => __( 'Color', 'weblexpro-dashboard' ),
				'name'          => 'color',
				'type'          => 'color_picker',
				'default_value' => '#ffffff',
			),
			array(
				'key'         => 'field_' . $key . '_catchphrase',
				'label'       => __( 'Catchphrase', 'weblexpro-dashboard' ),
				'name'        => 'catchphrase',
				'type'        => 'text',
				'placeholder' => __( 'catchphrase', 'weblexpro-dashboard' ),
			),
			array(
				'key'         => 'field_' . $key . '_description',
				'label'       => __( 'Description', 'weblexpro-dashboard' ),
				'name'        => 'description',
				'type'        => 'textarea',
				'rows'        => 4,
				'new_lines'   => 'br',
				'placeholder' => __( 'Description', 'weblexpro-dashboard' ),
			),
			array(
				'key'               => 'field_' . $key . '_links',
				'label'             => __( 'Links', 'weblexpro-dashboard' ),
				'name'              => 'links',
				'type'              => 'repeater',
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_' . $key . '_type',
							'operator' => '==',
							'value'    => 'eagle',
						),
					),
				),
				'layout'            => 'block',
				'button_label'      => __( 'Add Link', 'weblexpro-dashboard' ),
				'rows_per_page'     => 20,
				'sub_fields'        => array(
					array(
						'key'             => 'field_' . $key . '_links_link',
						'label'           => __( 'Link', 'weblexpro-dashboard' ),
						'name'            => 'link',
						'type'            => 'link',
						'return_format'   => 'array',
						'parent_repeater' => 'field_' . $key . '_links',
					),
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'            => 'group_' . $key,
					'title'          => __( 'Offer Post Fields', 'weblexpro-dashboard' ),
					'fields'         => $fields,
					'location'       => $location,
					'hide_on_screen' => $hide_on_screen,
					'menu_order'     => 0,
				)
			);

		}
	}
}
