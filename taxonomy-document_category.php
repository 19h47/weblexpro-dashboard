<?php // phpcs:ignore
/**
 * Taxonomy: Document Category
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 *
 * @version 1.0.0
 */

use Timber\{ Timber };

$queried_object = (array) get_queried_object();
$ancestors      = get_ancestors( $queried_object['term_id'], 'document_category', 'taxonomy' );

$filename = 'pages/archive-document.html.twig';

$data = Timber::context();

$data['children'] = Timber::get_terms(
	array(
		'taxonomy'   => 'document_category',
		'hide_empty' => false,
		'parent'     => $queried_object['term_id'],
	)
);

if ( $ancestors ) {
	$data['ancestors'] = Timber::get_terms( get_ancestors( $queried_object['term_id'], 'document_category', 'taxonomy' ) );
}

Timber::render( $filename, $data );
