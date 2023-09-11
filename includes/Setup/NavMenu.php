<?php // phpcs:ignore
/**
 * Nav Menu
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Setup;

use Timber\{Timber};

/**
 * Nav menu
 */
class NavMenu {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
	}

	/**
	 * Register nav menus
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_nav_menus/
	 *
	 * @return void
	 */
	public function register_menus(): void {
		register_nav_menus(
			array(
				'main' => __( 'Main Menu', 'weblexpro-dashboard' ),
			)
		);
	}


	/**
	 * Add to context
	 *
	 * @param array $context Timber context.
	 *
	 * @see https://developer.wordpress.org/reference/functions/get_registered_nav_menus/
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function add_to_context( array $context ): array {
		foreach ( array_keys( get_registered_nav_menus() ) as $location ) {
			if ( ! has_nav_menu( $location ) ) {
				continue;
			}

			$context['nav_menus'][ $location ] = Timber::get_menu( $location );
		}

		return $context;
	}
}
