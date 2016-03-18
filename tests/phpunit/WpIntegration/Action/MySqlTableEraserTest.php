<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	WpDbTypes\Type,
	wpdb,
	WP_UnitTestCase;

/**
 * Class MySqlTableEraserTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableEraserTest extends WP_UnitTestCase {

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
		parent::tearDown();
	}

	public function test_drop_table() {

		/* @var wpdb $wpdb */
		$wpdb   = $GLOBALS[ 'wpdb' ];
		$testee = new MySqlTableEraser(
			new Db\WpDbAdapter( $wpdb )
		);

		//Todo: Complete test
		$this->markTestIncomplete( "Under construction…" );
	}
}
