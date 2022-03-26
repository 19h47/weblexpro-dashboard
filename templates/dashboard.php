<?php
/**
 * Template Name: Dashboard
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 0.0.0
 * @version 0.0.0
 */

use Timber\{ Timber };

$filename = 'pages/dashboard-page.html.twig';

$data         = Timber::context();
$data['post'] = Timber::get_post();

Timber::render( $filename, $data );
