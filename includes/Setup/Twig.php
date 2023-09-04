<?php // phpcs:ignore
/**
 * Twig
 *
 * @package WordPress
 * @subpackage WebLexProDashboard/Setup/Theme
 */

namespace WebLexProDashboard\Setup;

use Twig\Extra\Html\{ HtmlExtension };
use Twig\Extra\Intl\{ IntlExtension };
use Twig\{ TwigFunction };

/**
 * Twig
 */
class Twig {

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'timber/twig', array( $this, 'add_functions' ) );
		add_filter( 'timber/twig', array( $this, 'add_extensions' ) );
		add_filter( 'timber/twig/environment/options', array( $this, 'set_environment_options' ), 10, 1 );
	}


	/**
	 * Set options
	 *
	 * @param array $options Array of options.
	 *
	 * @return array $options
	 */
	public function set_environment_options( array $options ) : array {
		$options['cache']       = WP_DEBUG ? false : true;
		$options['auto_reload'] = WP_DEBUG;

		return $options;
	}


	/**
	 * Add extensions
	 *
	 * @param object $twig Twig environment.
	 *
	 * @access public
	 *
	 * @return object $twig
	 */
	public function add_extensions( object $twig ) : object {
		$twig->addExtension( new HtmlExtension() );
		$twig->addExtension( new IntlExtension() );

		return $twig;
	}


	/**
	 * Add functions
	 *
	 * @param object $twig Twig environment.
	 *
	 * @access public
	 *
	 * @return object $twig
	 */
	public function add_functions( object $twig ) : object {
		$twig->addFunction(
			new TwigFunction(
				'html_class',
				function ( $args = '' ) {
					return html_class( $args );
				}
			)
		);

		$twig->addFunction(
			new TwigFunction(
				'body_class',
				function ( $args = '' ) {
					return body_class( $args );
				}
			)
		);

		if ( function_exists( 'get_extended' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'get_extended',
					function( $content ) {
						return get_extended( $content );
					}
				)
			);
		}

		if ( function_exists( 'wp_get_document_title' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'wp_get_document_title',
					function() {
						return wp_get_document_title();
					}
				)
			);
		}

		$twig->addFunction(
			new TwigFunction(
				'get_post_meta',
				function( int $post_id, string $key = '', bool $single = false ) {
					return get_post_meta( $post_id, $key, $single );
				}
			)
		);

		$twig->addFunction( new TwigFunction( 'uniqid', 'uniqid' ) );

		$twig->addFunction(
			new TwigFunction(
				'icon',
				function( $icon, $args = array() ) {
					return get_theme_icon( $icon, $args );
				}
			)
		);

		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'yoast_breadcrumb',
					function( $before = '', $after = '', $display = true ) {
						return yoast_breadcrumb( $before, $after, $display );
					}
				)
			);
		}

		if ( function_exists( 'pll_the_languages' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll_the_languages',
					function( array $args = array( 'raw' => 1 ) ) {
						return pll_the_languages( $args );
					}
				)
			);
		}

		$twig->addFunction(
			new TwigFunction(
				'wp_logout_url',
				function( string $redirect = '' ) {
					return wp_logout_url( $redirect );
				}
			)
		);

		$twig->addFunction(
			new TwigFunction(
				'asset',
				function( string $asset, bool $echo = false ) {
					return asset( $asset, $echo );
				}
			)
		);

		return $twig;
	}
}
