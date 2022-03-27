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
		register_extended_field_group(
			array(
				'title'    => __( 'Document', 'weblexprodashboard' ),
				'style'    => 'default',
				'fields'   => array(
					Repeater::make( __( 'Documents', 'weblexprodashboard' ) )->fields(
						array(
							Text::make( __( 'Title', 'weblexprodashboard' ) )->placeholder( __( 'Title', 'weblexprodashboard' ) ),
							File::make( __( 'File', 'weblexprodashboard' ), ),
						)
					)->layout( 'block' ),
				),
				'location' => array(
					Location::where( 'post_type', 'document' ),
				),
			)
		);
	}
}
