<?php // phpcs:ignore
/**
 * User Form Fields
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF\Fields;

/**
 * User Form Fields
 */
class UserFormFields {

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
		$key            = 'user_form';
		$hide_on_screen = array();

		$location = array(
			array(
				array(
					'param'    => 'user_form',
					'operator' => '==',
					'value'    => 'all',
				),
				array(
					'param'    => 'user_role',
					'operator' => '==',
					'value'    => 'administrator',
				),
			),
		);

		$fields = array(
			array(
				'key'           => 'field_' . $key . '_offers',
				'label'         => __( 'Offers', 'weblexpro-dashboard' ),
				'name'          => 'offers',
				'type'          => 'post_object',
				'post_type'     => array( 'offer' ),
				'return_format' => 'id',
				'multiple'      => 1,
			),
			array(
				'key'           => 'field_' . $key . '_likes',
				'label'         => __( 'Likes', 'weblexpro-dashboard' ),
				'name'          => 'likes',
				'type'          => 'relationship',
				'post_type'     => array( 'document', 'attachment' ),
				'post_status'   => '',
				'taxonomy'      => '',
				'filters'       => '',
				'return_format' => 'id',
			),
			array(
				'key'          => 'field_' . $key . '_documents',
				'label'        => __( 'Documents', 'weblexpro-dashboard' ),
				'name'         => 'documents',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => __( 'Add Category', 'weblexpro-dashboard' ),
				'sub_fields'   => array(
					array(
						'key'             => 'field_' . $key . '_documents_category',
						'label'           => __( 'Category', 'weblexpro-dashboard' ),
						'name'            => 'category',
						'type'            => 'text',
						'placeholder'     => __( 'Category', 'weblexpro-dashboard' ),
						'parent_repeater' => 'field_' . $key . '_documents',
					),
					array(
						'key'             => 'field_' . $key . '_documents_documents',
						'label'           => __( 'Documents', 'weblexpro-dashboard' ),
						'name'            => 'documents',
						'type'            => 'repeater',
						'layout'          => 'block',
						'button_label'    => __( 'Add Document', 'weblexpro-dashboard' ),
						'sub_fields'      => array(
							array(
								'key'             => 'field_' . $key . '_documents_documents_title',
								'label'           => __( 'Title', 'weblexpro-dashboard' ),
								'name'            => 'title',
								'type'            => 'text',
								'placeholder'     => __( 'Title', 'weblexpro-dashboard' ),
								'parent_repeater' => 'field_' . $key . '_documents_documents',
							),
							array(
								'key'             => 'field_' . $key . '_documents_documents_file',
								'label'           => __( 'File', 'weblexpro-dashboard' ),
								'name'            => 'file',
								'type'            => 'file',
								'return_format'   => 'array',
								'library'         => 'all',
								'parent_repeater' => 'field_' . $key . '_documents_documents',
							),
						),
						'parent_repeater' => 'field_' . $key . '_documents',
					),
				),
			),
			array(
				'key'          => 'field_' . $key . '_mag_url',
				'label'        => __( 'Mag URL', 'weblexpro-dashboard' ),
				'name'         => 'mag_url',
				'type'         => 'url',
				'instructions' => __( 'Indicate the URL of the magazine to integrate for users who have subscribed to the Mag offer.', 'weblexpro-dashboard' ),
				'placeholder'  => __( 'https://mag-experts.fr/weblex/', 'weblexpro-dashboard' ),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $key,
					'title'    => __( 'Users', 'weblexpro-dashboard' ),
					'fields'   => $fields,
					'location' => $location,
					'active'   => true,
				)
			);

		}
	}
}
