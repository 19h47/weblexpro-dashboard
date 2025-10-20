<?php
/**
 * WebLexProDashboard functions and definitions
 *
 * @package    WordPress
 * @subpackage WeblexProDashboard
 */
// Autoloader.
require_once get_template_directory() . '/vendor/autoload.php';

use Timber\{ Timber };

Timber::init();
// Set Timber template locations
Timber::$locations = array( 'views', 'public' );

WebLexProDashboard\Init::run_services();
