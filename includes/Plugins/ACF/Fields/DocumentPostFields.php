<?php // phpcs:ignore
/**
 * Document Post Fields
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF\Fields;

/**
 * Document Post Fields
 */
class DocumentPostFields {


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
		$key = 'document_post';

		$documents = array(
			'key'          => 'field_' . $key . '_documents',
			'label'        => __( 'Documents', 'weblexpro-dashboard' ),
			'name'         => 'documents',
			'type'         => 'repeater',
			'layout'       => 'block',
			'button_label' => __( 'Add Document', 'weblexpro-dashboard' ),
			'sub_fields'   => array(
				array(
					'key'         => 'field_' . $key . '_documents_title',
					'label'       => __( 'Title', 'weblexpro-dashboard' ),
					'name'        => 'title',
					'type'        => 'text',
					'placeholder' => __( 'Title', 'weblexpro-dashboard' ),
					'wrapper'     => array( 'width' => 4 / 12 * 100 ),
				),
				array(
					'key'     => 'field_' . $key . '_documents_file',
					'label'   => __( 'File', 'weblexpro-dashboard' ),
					'name'    => 'file',
					'type'    => 'file',
					'wrapper' => array( 'width' => 8 / 12 * 100 ),
				),
			),
		);

		$location = array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'document',
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_document',
					'title'    => __( 'Document', 'weblexpro-dashboard' ),
					'fields'   => array(
						$documents,
						array(
							'key'     => 'field_' . $key . '_archive',
							'label'   => __( 'Archive', 'weblexpro-dashboard' ),
							'name'    => 'archive',
							'type'    => 'file',
						),
					),
					'location' => $location,
				)
			);
		}
	}
}
