<?php // phpcs:ignore
/**
 * Bootstraps WordPress theme related functions, most importantly enqueuing javascript and styles.
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 * @since 0.0.0
 */

namespace WebLexProDashboard\Setup;

use Timber\{ Timber };
use Twig\{ TwigFunction };
use Twig\Extra\Html\HtmlExtension;
use WebLexProDashboard\Models\{ Page };
use WP_Post;

$timber = new Timber();

Timber::$dirname = array( 'views', 'templates', 'dist' );

/**
 * Theme
 */
class Theme {

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber/context', array( $this, 'add_socials_to_context' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/context', array( $this, 'add_to_theme' ) );
		add_filter( 'timber/post/classmap', array( $this, 'add_post_classmap' ) );
	}


	/**
	 * Add to theme
	 *
	 * @param array $context Timber context.
	 */
	public function add_to_theme( array $context ) : array {
		$manifest = get_theme_manifest();

		$context['theme']->manifest = array();

		foreach ( $manifest as $label => $path ) {
			$context['theme']->manifest[ $label ] = get_template_directory_uri() . '/' . $path;
		}

		return $context;
	}


	/**
	 * Add to Twig
	 *
	 * @param object $twig Twig environment.
	 * @return object $twig
	 * @access public
	 */
	public function add_to_twig( object $twig ) : object {
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

		$twig->addFunction(
			new TwigFunction(
				'set_product_global',
				function( $post ) {
					return set_product_global( $post );
				}
			)
		);

		if ( function_exists( 'pll_the_languages' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll_the_languages',
					function( $args = array() ) {
						return pll_the_languages( array_merge( $args, array( 'raw' => 1 ) ) );
					}
				)
			);
		}

		if ( function_exists( 'pll__' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll__',
					function ( string $string ) : string {
						return pll__( $string );
					}
				)
			);
		}

		if ( function_exists( 'sanitize_title' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'sanitize_title',
					function ( string $title, string $fallback_title = '', string $context = 'save' ) : string {
						return sanitize_title( $title, $fallback_title, $context );
					}
				)
			);
		}

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
				'is_user_logged_in',
				function() {
					return is_user_logged_in();
				}
			)
		);

		$twig->addFunction(
			new TwigFunction(
				'wp_login_url',
				function( string $redirect = '', bool $force_reauth = false ) {
					return wp_login_url( $redirect, $force_reauth );
				}
			)
		);

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

		$twig->addExtension( new HtmlExtension() );

		return $twig;
	}


	/**
	 * Add socials to context
	 *
	 * @param array $context Timber context.
	 * @return array
	 */
	public function add_socials_to_context( array $context ) : array {
		// Share and Socials links.
		$socials = array(
			array(
				'title' => 'Instagram',
				'slug'  => 'instagram',
				'url'   => get_option( 'instagram' ),
			),
			array(
				'title' => 'Twitter',
				'slug'  => 'twitter',
				'name'  => __( 'Share on Twitter', 'weblexprodashboard' ),
				'link'  => 'https://twitter.com/intent/tweet?url=',
				'url'   => get_option( 'twitter' ),
				'color' => '#1da1f2',
			),
			array(
				'title' => 'Facebook',
				'slug'  => 'facebook',
				'name'  => __( 'Share on Facebook', 'weblexprodashboard' ),
				'link'  => 'https://www.facebook.com/sharer.php?u=',
				'url'   => get_option( 'facebook' ),
				'color' => '#3b5998',
			),
			array(
				'title' => 'YouTube',
				'slug'  => 'youtube',
				'url'   => get_option( 'youtube' ),
				'color' => '#ff0000',
			),
			array(
				'title' => 'Pinterest',
				'slug'  => 'pinterest',
				'name'  => __( 'Share on Pinterest', 'weblexprodashboard' ),
				'link'  => 'https://pinterest.com/pin/create/link/?url=',
				'color' => '#e60023',
			),
			array(
				'title' => 'LinkedIn',
				'slug'  => 'linkedin',
				'name'  => __( 'Share on LinkedIn', 'weblexprodashboard' ),
				'link'  => 'https://www.linkedin.com/sharing/share-offsite/?url=',
				'url'   => get_option( 'linkedin' ),
				'color' => '#0077b5',
			),
		);

		foreach ( $socials as $social ) {
			if ( ! empty( $social['url'] ) ) {
				$context['socials'][ $social['slug'] ] = $social;
			}

			if ( ! empty( $social['link'] ) ) {
				$context['shares'][ $social['slug'] ] = $social;
			}
		}

		return $context;
	}


	/**
	 * Add to context
	 *
	 * @param array $context Timber context.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function add_to_context( array $context ) : array {
		global $wp;

		$context['current_url']   = home_url( add_query_arg( array(), $wp->request ) );
		$context['front_url']     = get_permalink( get_option( 'page_on_front' ) );
		$context['dashboard_url'] = get_permalink( get_option( 'page_dashboard' ) );

		$context['document_categories'] = Timber::get_terms(
			array(
				'taxonomy'   => 'document_category',
				'parent'     => 0,
				'hide_empty' => false,
			)
		);

		return $context;
	}

	/**
	 * Add post classmap
	 *
	 * @param array $classmap Class map.
	 *
	 * @return array
	 */
	public function add_post_classmap( $classmap ) : array {
		$custom_classmap = array(
			'page' => function( WP_Post $post ) {
				return Page::class;
			},
		);

		return array_merge( $classmap, $custom_classmap );
	}
}
