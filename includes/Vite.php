<?php
/**
 * Vite
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard;

use Exception;

/**
 * Vite
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */
class Vite {

	/**
	 * Flag to determine whether hot server is active.
	 *
	 * Calculated when Vite::run() is called.
	 *
	 * @var bool
	 */
	private static bool $is_hot = false;

	/**
	 * The URI to the hot server.
	 *
	 * Calculated when Vite::run() is called.
	 *
	 * @var string
	 */
	private static string $server;

	/**
	 * The path where compiled assets will go.
	 *
	 * @var string
	 */
	private static string $build_path = 'dist';

	/**
	 * Manifest file contents.
	 *
	 * Initialised when Vite::run() is called.
	 *
	 * @var array
	 */
	private static array $manifest = array();


	/**
	 * Run
	 *
	 * @param  string|null $build_path
	 * @param  bool        $output  Whether to output the Vite client.
	 *
	 * @return string|null
	 * @throws Exception
	 */
	public static function run( ?string $build_path = null, bool $output = true ): ?string {
		if ( is_admin() || wp_doing_ajax() || wp_is_json_request() ) {
			return null;
		}

		static::$is_hot = file_exists( static::hot_file_path() );

		// have we got a build path override?
		if ( $build_path ) {
			static::$build_path = $build_path;
		}

		// are we running hot?
		if ( static::$is_hot ) {
			static::$server = file_get_contents( static::hot_file_path() );
			$client         = static::$server . '/@vite/client';

			// if output
			if ( $output ) {
				printf( /** @lang text */ '<script type="module" src="%s"></script>', $client );
			}

			return $client;
		}

		// we must have a manifest file...
		$manifest_path = static::build_path() . '/.vite/manifest.json';

		if ( ! file_exists( $manifest_path ) ) {
			throw new Exception( __( 'No Vite Manifest exists. Should hot server be running?', 'weblexpro-dashboard' ) );
		}

		// store our manifest contents.
		static::$manifest = json_decode( file_get_contents( $manifest_path ), true );

		return null;
	}

	/**
	 * Enqueue the script module
	 *
	 * @param string|null $build_path
	 *
	 * @return void
	 * @throws Exception
	 */
	public static function enqueue_script_module( ?string $build_path = null ): void {
		// we only want to continue if we have a client.
		if ( ! $client = self::run( $build_path, false ) ) {
			return;
		}

		// enqueue our client script
		wp_enqueue_script_module( 'vite-client', $client, array(), null );
	}

	/**
	 * Return URI path to an asset.
	 *
	 * @param $asset
	 *
	 * @return string
	 * @throws Exception
	 */
	public static function asset( $asset ): string {
		if ( static::$is_hot ) {
			return static::$server . '/' . ltrim( $asset, '/' );
		}

		if ( ! array_key_exists( $asset, static::$manifest ) ) {
			throw new Exception( printf( __( 'Unknown Vite build asset: %s', 'weblexpro-dashboard' ), $asset ) );
		}

		return implode( '/', array( get_stylesheet_directory_uri(), static::$build_path, static::$manifest[ $asset ]['file'] ) );
	}

	/**
	 * Internal method to determine hot_file_path.
	 *
	 * @return string
	 */
	private static function hot_file_path(): string {
		return implode( '/', array( static::build_path(), 'hot' ) );
	}

	/**
	 * Internal method to determine build_path.
	 *
	 * @return string
	 */
	private static function build_path(): string {
		return implode( '/', array( get_stylesheet_directory(), static::$build_path ) );
	}

	/**
	 * Return URI path to an image.
	 *
	 * @param $img
	 *
	 * @return string|null
	 * @throws Exception
	 */
	public static function img( $img ): ?string {

		try {

			// set the asset path to the image.
			$asset = 'src/img/' . ltrim( $img, '/' );

			// if we're not running hot, return the asset.
			return static::asset( $asset );

		} catch ( Exception $e ) {

			// handle the exception here or log it if needed.
			// you can also return a default image or null in case of an error.
			return $e->getMessage(); // optionally, you can retrieve the error message

		}
	}
}
