<?php // phpcs:ignore
/**
 * Query
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\WP;

use WP_Query;

/**
 * Query
 */
class Query {


	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'pre_get_posts', array( $this, 'pre_get_search' ), 10, 1 );
		add_filter( 'query_vars', array( $this, 'add_custom_query_var' ), 10, 1 );
	}

	/**
	 * Pre get search
	 *
	 * @param WP_Query $query The WP_Query instance (passed by reference).
	 */
	public function pre_get_search( WP_Query $query ) {
		if ( is_admin() ) {
			return;
		}

		if ( ! $query->is_main_query() ) {
			return;
		}

		if ( ! $query->is_search() ) {
			return;
		}

		$query->set( 'posts_per_page', -1 );
	}

	/**
	 * Add custom query var
	 *
	 * @param string[] $public_query_vars The array of allowed query variable names.
	 *
	 * @return array $public_query_vars
	 */
	public function add_custom_query_var( array $public_query_vars ): array {
		$public_query_vars[] = 'products';

		return $public_query_vars;
	}
}
