<?php // phpcs:ignore
/**
 * AdminHeader
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard;

/**
 * AdminHeader
 */
class AdminHeader {


	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'admin_head', array( $this, 'admin_head' ) );
	}

	function admin_head() {
		if ( ! current_user_can( 'administrator' ) ) {
			echo '<style>
				.show-admin-bar.user-admin-bar-front-wrap {
					display: none;
				}
	  		</style>';
		}
	}
}
