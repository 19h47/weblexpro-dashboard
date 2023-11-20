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
$filename       = 'pages/archive-document.html.twig';

$data = Timber::context();

$data['term']  = Timber::get_term( $queried_object['term_id'] );
$data['posts'] = $data['term']->posts(
	array(
		'posts_per_page' => -1,
		'post_type'      => 'document',
	)
);

Timber::render( $filename, $data );
