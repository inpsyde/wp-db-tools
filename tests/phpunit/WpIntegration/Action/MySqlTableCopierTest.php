<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	WpDbTypes\Type,
	wpdb,
	WP_UnitTestCase;

/**
 * Class MySqlTableCopierTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableCopierTest extends WP_UnitTestCase {

	public function setUp() {

		parent::setUp();
		/**
		 * WP_UnitTestCase::_start_transaction set these filters which
		 * transform a CREATE TABLE to CREATE TEMPORARY TABLE
		 */
		remove_filter( 'query', [ $this, '_create_temporary_tables' ] );
		remove_filter( 'query', [ $this, '_drop_temporary_tables' ] );
	}

	public function tearDown() {

		//cleanup
		add_filter( 'query', [ $this, '_create_temporary_tables' ] );
		add_filter( 'query', [ $this, '_drop_temporary_tables' ] );
	}

	public function test_copy_structure() {


		/* @var wpdb $wpdb */
		$wpdb         = $GLOBALS[ 'wpdb' ];
		$origin_table = new Type\NamedTable( $wpdb->options );
		$new_table    = new Type\NamedTable( "new_{$wpdb->options}_table" );
		$wpdb->query( "DROP TABLE IF EXISTS `{$new_table->name()}`" );
		$tables       = $wpdb->get_col( 'SHOW TABLES' );

		// Make sure origin_table exists, but new table not
		$this->assertContains(
			(string) $origin_table,
			$tables,
			"Pre-condition for test failed. Table {$origin_table->name()} does not exist."
		);
		$this->assertNotContains(
			(string) $new_table,
			$tables,
			"Pre-condition for test failed. Table {$origin_table->name()} already exists."
		);

		$testee = new MySqlTableCopier(
			new Db\WpDbAdapter( $wpdb )
		);
		$testee->copy_structure( $origin_table, $new_table );

		$tables = $wpdb->get_col( 'SHOW TABLES' );
		$this->assertContains(
			(string) $origin_table,
			$tables
		);
		$this->assertContains(
			(string) $new_table,
			$tables
		);
	}
}
