<?php // phpcs:ignore
/**
 * Document Fields
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF;

use WordPlate\Acf\Fields\{ File, Repeater, Text };
use WordPlate\Acf\Location;

/**
 * Document Fields
 */
class DocumentFields {
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
		$documents = array(
			'key'          => 'field_documents',
			'label'        => __( 'Documents', 'weblexprodashboard' ),
			'name'         => 'documents',
			'type'         => 'repeater',
			'layout'       => 'block',
			'button_label' => __( 'Add Document', 'weblexprodashboard' ),
			'sub_fields'   => array(
				array(
					'key'         => 'field_documents_title',
					'label'       => __( 'Title', 'weblexprodashboard' ),
					'name'        => 'title',
					'type'        => 'text',
					'placeholder' => __( 'Title', 'weblexprodashboard' ),
				),
				array(
					'key'   => 'field_documents_file',
					'label' => __( 'File', 'weblexprodashboard' ),
					'name'  => 'file',
					'type'  => 'file',
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
					'title'    => __( 'Document', 'weblexprodashboard' ),
					'fields'   => array( $documents ),
					'location' => $location,
				)
			);
		}
	}
}
