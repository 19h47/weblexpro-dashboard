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

$data['term'] = Timber::get_term( $queried_object['term_id'] );

Timber::render( $filename, $data );
