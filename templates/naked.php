<?php
/**
 * Template Name: Naked
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 0.0.1
 * @version 0.0.1
 */

use Timber\{ Timber };

$filename = 'pages/naked-page.html.twig';

$data                      = Timber::context();
$data['post']              = Timber::get_post();
$data['password_required'] = post_password_required( $post->ID );

Timber::render( $filename, $data );
