<?php // phpcs:ignore
/**
 * Document Category Fields
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Plugins\ACF;

use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Location;

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
		register_extended_field_group(
			array(
				'title'    => __( 'Document Category', 'weblexprodashboard' ),
				'fields'   => array(
					Image::make( __( 'Thumbnail', 'weblexprodashboard' ), 'thumbnail' )->returnFormat( 'id' ),
				),
				'location' => array(
					Location::where( 'taxonomy', 'document_category' ),
				),
			)
		);
	}
}
