<?php // phpcs:ignore
/**
 * Single: Document
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 *
 * @version 1.0.0
 */

use Timber\{ Timber };

$filename = 'pages/single-document.html.twig';

$data         = Timber::context();
$data['post'] = Timber::get_post();

Timber::render( $filename, $data );
