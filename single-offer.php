<?php
/**
 * Single: Offer
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage WeblexProDashboard
 * @since 0.0.0
 */

use Timber\{ Timber };

$templates = array( 'pages/single-offer.html.twig' );
$data      = Timber::context();

Timber::render( $templates, $data );
