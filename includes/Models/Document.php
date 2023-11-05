<?php // phpcs:ignore
/**
 * Document
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Models;

use Timber\{Timber, Post};

/**
 * Class Document
 */
class Document extends Post {

	/**
	 * Ancestors
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function ancestors() {
		$terms     = $this->terms(
			array(
				'taxonomy'   => 'document_category',
				'object_ids' => $this->ID,
			)
		);
		$ancestors = get_ancestors( $terms[0]->id, 'document_category', 'taxonomy' );

		if ( is_array( $ancestors ) && ! empty( $ancestors ) ) {
			return array_reverse( (array) Timber::get_terms( $ancestors ) );
		}

		return $terms;
	}

	/**
	 * Offer
	 *
	 * @return
	 */
	public function offer() {
		if ( $this->ancestors and $this->ancestors[0] ) {

			return Timber::get_posts(
				array(
					'post_type'  => 'offer',
					'meta_key'   => 'type',
					'meta_value' => $this->ancestors[0]->meta( 'type' ),
				)
			);
		}

		return array();
	}
}
