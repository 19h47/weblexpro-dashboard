<?php // phpcs:ignore
/**
 * Bootstraps WordPress theme related functions, most importantly enqueuing javascript and styles.
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 * @since      0.0.0
 */

namespace WebLexProDashboard\Setup;

use Timber\{ Timber, Site };
use Twig\{ TwigFunction };
use Twig\Extra\Html\HtmlExtension;
use WebLexProDashboard\Models\{ Document, Page };
use WP_Post;

Timber::init();
Timber::$dirname = array( 'views', 'templates', 'dist' );

/**
 * Theme
 */
class Theme extends Site {


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function run(): void {
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
	public function add_to_theme( array $context ): array {
		$manifest = get_theme_manifest();

		$context['theme']->manifest = array();

		foreach ( $manifest as $label => $path ) {
			$context['theme']->manifest[ $label ] = get_template_directory_uri() . '/' . $path;
		}

		return $context;
	}


	/**
	 * Add socials to context
	 *
	 * @param  array $context Timber context.
	 * @return array
	 */
	public function add_socials_to_context( array $context ): array {
		// Share and Socials links.
		$socials = array(
			array(
				'title' => 'Facebook',
				'slug'  => 'facebook',
				'name'  => __( 'Share on Facebook', 'weblexpro-dashboard' ),
				'link'  => 'https://www.facebook.com/sharer.php?u=',
				'url'   => get_option( 'facebook' ),
				'color' => '#3b5998',
			),
			array(
				'title' => 'Twitter',
				'slug'  => 'twitter',
				'name'  => __( 'Share on Twitter', 'weblexpro-dashboard' ),
				'link'  => 'https://twitter.com/intent/tweet?url=',
				'url'   => get_option( 'twitter' ),
				'color' => '#1da1f2',
			),
			array(
				'title' => 'LinkedIn',
				'slug'  => 'linkedin',
				'name'  => __( 'Share on LinkedIn', 'weblexpro-dashboard' ),
				'link'  => 'https://www.linkedin.com/sharing/share-offsite/?url=',
				'url'   => get_option( 'linkedin' ),
				'color' => '#0077b5',
			),
			array(
				'title' => 'Instagram',
				'slug'  => 'instagram',
				'url'   => get_option( 'instagram' ),
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
				'name'  => __( 'Share on Pinterest', 'weblexpro-dashboard' ),
				'link'  => 'https://pinterest.com/pin/create/link/?url=',
				'color' => '#e60023',
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
	public function add_to_context( array $context ): array {
		global $wp;

		$context['current_url']           = home_url( add_query_arg( array(), $wp->request ) );
		$context['front_url']             = get_permalink( get_option( 'page_on_front' ) );
		$context['dashboard_url']         = get_permalink( get_option( 'page_dashboard' ) );
		$context['contact_url']           = get_permalink( get_option( 'page_contact' ) );
		$context['likes_url']             = get_permalink( get_option( 'page_likes' ) );
		$context['documents_url']         = get_permalink( get_option( 'page_documents' ) );
		$context['phone_number']          = get_option( 'phone_number' );
		$context['notice']                = get_option( 'notice' );
		$context['url_weblexpro_contact'] = get_option( 'url_weblexpro_contact' );

		return $context;
	}

	/**
	 * Add post classmap
	 *
	 * @param array $classmap Class map.
	 *
	 * @return array
	 */
	public function add_post_classmap( $classmap ): array {
		$custom_classmap = array(
			'page'     => function ( WP_Post $post ) {
				return Page::class;
			},
			'document' => function ( WP_Post $post ) {
				return Document::class;
			},
		);

		return array_merge( $classmap, $custom_classmap );
	}
}
