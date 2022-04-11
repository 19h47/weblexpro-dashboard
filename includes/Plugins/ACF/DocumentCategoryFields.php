<?php // phpcs:ignore
/**
 * Document Category Fields
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF;

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
		add_action( 'acf/init', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group.
	 *
	 * @return void
	 */
	public function fields() {
		$image = array(
			'key'           => 'field_thumbnail',
			'label'         => __( 'Thumbnail', 'weblexprodashboard' ),
			'name'          => 'thumbnail',
			'type'          => 'image',
			'return_format' => 'id',
		);

		$location = array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'document_category',
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_document_category',
					'title'    => __( 'Document Category', 'weblexprodashboard' ),
					'fields'   => array( $image ),
					'location' => $location,
				)
			);
		}
	}
}
