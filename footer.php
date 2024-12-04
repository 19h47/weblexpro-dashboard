<?php
/**
 * Third party plugins that hijack the theme will call wp_footer() to get the footer template.
 * We use this to end our output buffer (started in header.php) and render into the view/page-plugin.twig template.
 *
 * If you're not using a plugin that requries this behavior (ones that do include Events Calendar Pro and
 * WooCommerce) you can delete this file and header.php
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

 use Timber\{ Timber };

$data = $GLOBALS['timberContext']; // @codingStandardsIgnoreFile

if ( ! isset( $data ) ) {
	throw new \Exception( 'Timber context not set in footer.' );
}
$data['post'] = array( 'content' => ob_get_contents() );

ob_end_clean();

$templates = array( 'index.html.twig' );

Timber::render( $templates, $data );
