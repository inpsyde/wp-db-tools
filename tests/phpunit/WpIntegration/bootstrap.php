<?php # -*- coding: utf-8 -*-

namespace WpDbTools;

use
	WpTestsStarter;

$base_dir = dirname(
	dirname( // /tests
		dirname( __DIR__ ) // /phpunit;
	)
);

$autoload = "{$base_dir}/vendor/autoload.php";
$wp_path  = "{$base_dir}/vendor/inpsyde/wordpress-dev";
if ( file_exists( $autoload ) ) {
	require_once $autoload;
}

$starter = new WpTestsStarter\WpTestsStarter( $wp_path );
/**
 * constants are defined by phpunit
 * @see phpunit-integration.xml.dist
 */
$starter->defineDbName( DB_NAME );
$starter->defineDbUser( DB_USER );
$starter->defineDbPassword( DB_PASS );
$starter->defineDbHost( DB_HOST );
$starter->setTablePrefix( TABLE_PREFIX );

$starter->bootstrap();