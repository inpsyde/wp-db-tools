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

	private $new_tables = [ ];

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

		foreach ( $this->new_tables as $table ) {
			$GLOBALS[ 'wpdb' ]->query(
				"DROP TABLE IF EXISTS `{$table}`"
			);
		}
		$this->new_tables = [ ];
		//cleanup
		add_filter( 'query', [ $this, '_create_temporary_tables' ] );
		add_filter( 'query', [ $this, '_drop_temporary_tables' ] );
		parent::tearDown();
	}

	public function test_copy_structure() {

		/* @var wpdb $wpdb */
		$wpdb               = $GLOBALS[ 'wpdb' ];
		$origin_table       = new Type\NamedTable( $wpdb->options );
		$new_table          = new Type\NamedTable( "new_{$wpdb->options}_table_structure" );
		$this->new_tables[] = $new_table;
		// drop table if previous test failed
		$wpdb->query( "DROP TABLE IF EXISTS `{$new_table}`" );
		$tables = $wpdb->get_col( 'SHOW TABLES' );

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

		$new_table_length = $wpdb->get_var( "SELECT COUNT(*) FROM `{$new_table}`" );
		$this->assertSame(
			0,
			(int) $new_table_length
		);

		// @todo
		$this->markTestIncomplete( "Does not check if the table is actually empty when the original table was not empty" );
	}

	public function test_copy_table() {

		/* @var wpdb $wpdb */
		$wpdb               = $GLOBALS[ 'wpdb' ];
		$origin_table       = new Type\NamedTable( $wpdb->options );
		$new_table          = new Type\NamedTable( "new_{$wpdb->options}_table" );
		$this->new_tables[] = $new_table;
		$wpdb->query( "DROP TABLE IF EXISTS `{$new_table}`" );
		$tables = $wpdb->get_col( 'SHOW TABLES' );

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
		$testee->copy( $origin_table, $new_table );

		$new_table_length = $wpdb->get_var( "SELECT COUNT(*) FROM `{$new_table}`" );

		$this->assertGreaterThan(
			0,
			(int) $new_table_length
		);

		// @todo
		$this->markTestIncomplete( "Test will fail if the original table is empty" );
	}
}
