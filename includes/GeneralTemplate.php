<?php // phpcs:ignore
/**
 * General Template
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard;

/**
 * General Template
 */
class GeneralTemplate {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'loginout', array( $this, 'loginout' ), 10, 1 );
	}

	/**
	 * Loginout
	 *
	 * @param string $loginout The loginout string.
	 */
	public function loginout( string $loginout ) : string {
		$loginout = str_replace( '<a', '<a class="w-full button"', $loginout );

		return $loginout;
	}
}
