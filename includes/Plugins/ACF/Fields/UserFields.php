<?php // phpcs:ignore
/**
 * User Fields
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF\Fields;

/**
 * User Fields
 */
class UserFields {
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
		$key            = 'user';
		$hide_on_screen = array();

		$location = array(
			array(
				array(
					'param'    => 'current_user',
					'operator' => '==',
					'value'    => 'viewing_back',
				),
			),
		);

		$fields = array(
			array(
				'key'           => 'field_' . $key . '_offers',
				'label'         => __( 'Offers', 'weblexprodashboard' ),
				'name'          => 'offers',
				'type'          => 'post_object',
				'post_type'     => array( 'offer' ),
				'return_format' => 'id',
				'multiple'      => 1,
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $key,
					'title'    => __( 'Users', 'weblexprodashboard' ),
					'fields'   => $fields,
					'location' => $location,
					'active'   => true,
				)
			);

		}
	}
}
