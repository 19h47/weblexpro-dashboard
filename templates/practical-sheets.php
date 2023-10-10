<?php
/**
 * Template Name: Practical Sheets
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 0.0.0
 * @version 0.0.0
 */

use Timber\{ Timber };

$filename = 'pages/practical-sheets.html.twig';
$data     = Timber::context();

Timber::render( $filename, $data );
