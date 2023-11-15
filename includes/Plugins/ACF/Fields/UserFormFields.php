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
		$key = 'user_form';

		$location = array(
			array(
				array(
					'param'    => 'user_form',
					'operator' => '==',
					'value'    => 'all',
				),
				array(
					'param'    => 'current_user_role',
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
				'key'        => 'field_' . $key . '_documents',
				'label'      => __( 'Documents', 'weblexpro-dashboard' ),
				'name'       => 'documents',
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'field_' . $key . '_documents_bills',
						'label'        => __( 'Bills', 'weblexpro-dashboard' ),
						'name'         => 'bills',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => __( 'Add Bill', 'weblexpro-dashboard' ),
						'sub_fields'   => array(
							array(
								'key'             => 'field_' . $key . '_documents_bills_title',
								'label'           => __( 'Title', 'weblexpro-dashboard' ),
								'name'            => 'title',
								'type'            => 'text',
								'placeholder'     => __( 'Title', 'weblexpro-dashboard' ),
								'parent_repeater' => 'field_' . $key . '_documents_bills',
							),
							array(
								'key'             => 'field_' . $key . '_documents_bills_file',
								'label'           => __( 'File', 'weblexpro-dashboard' ),
								'name'            => 'file',
								'type'            => 'file',
								'return_format'   => 'array',
								'library'         => 'all',
								'parent_repeater' => 'field_' . $key . '_documents_bills',
							),
						),
					),
					array(
						'key'          => 'field_' . $key . '_documents_contracts',
						'label'        => __( 'Contracts', 'weblexpro-dashboard' ),
						'name'         => 'contracts',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => __( 'Add Contracts', 'weblexpro-dashboard' ),
						'sub_fields'   => array(
							array(
								'key'             => 'field_' . $key . '_documents_contracts_title',
								'label'           => __( 'Title', 'weblexpro-dashboard' ),
								'name'            => 'title',
								'type'            => 'text',
								'placeholder'     => __( 'Title', 'weblexpro-dashboard' ),
								'parent_repeater' => 'field_' . $key . '_documents_contracts',
							),
							array(
								'key'             => 'field_' . $key . '_documents_contracts_file',
								'label'           => __( 'File', 'weblexpro-dashboard' ),
								'name'            => 'file',
								'type'            => 'file',
								'return_format'   => 'array',
								'library'         => 'all',
								'parent_repeater' => 'field_' . $key . '_documents_contracts',
							),
						),
					),
					array(
						'key'          => 'field_' . $key . '_documents_practical_sheets',
						'label'        => __( 'Practical Sheets', 'weblexpro-dashboard' ),
						'name'         => 'practical_sheets',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => __( 'Add Practical Sheets', 'weblexpro-dashboard' ),
						'sub_fields'   => array(
							array(
								'key'             => 'field_' . $key . '_documents_practical_sheets_title',
								'label'           => __( 'Title', 'weblexpro-dashboard' ),
								'name'            => 'title',
								'type'            => 'text',
								'placeholder'     => __( 'Title', 'weblexpro-dashboard' ),
								'parent_repeater' => 'field_' . $key . '_documents_practical_sheets',
							),
							array(
								'key'             => 'field_' . $key . '_documents_practical_sheets_file',
								'label'           => __( 'File', 'weblexpro-dashboard' ),
								'name'            => 'file',
								'type'            => 'file',
								'return_format'   => 'array',
								'library'         => 'all',
								'parent_repeater' => 'field_' . $key . '_documents_practical_sheets',
							),
						),
					),
				),
			),
			array(
				'key'               => 'field_' . $key . '_links',
				'label'             => __( 'Links', 'weblexpro-dashboard' ),
				'name'              => 'links',
				'type'              => 'repeater',
				'instructions' => __( 'Indicate the links for users who have subscribed to the Eagle offer.', 'weblexpro-dashboard' ),
				'layout'            => 'block',
				'button_label'      => __( 'Add Link', 'weblexpro-dashboard' ),
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
