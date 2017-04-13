<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use WpDbTools\Db;
use wpdb;
use WP_UnitTestCase;
use Mockery;
use WpDbTools\Type\Table;

/**
 * Class MySqlTableLookupTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableLookupTest extends WP_UnitTestCase {

	public function test_table_exists() {

		/** @var wpdb $wpdb */
		$wpdb = $GLOBALS[ 'wpdb' ];
		$table_mock = Mockery::mock( Table::class );
		$table_mock->shouldReceive( '__toString' )
			->andReturn( $wpdb->posts );
		$table_mock->shouldReceive( 'name' )
			->andReturn( $wpdb->posts );

		$testee = new MySqlTableLookup(
			new Db\WpDbAdapter( $wpdb )
		);

		$this->assertTrue(
			$testee->table_exists( $table_mock )
		);
	}
	public function test_not_table_exists() {

		/** @var wpdb $wpdb */
		$wpdb = $GLOBALS[ 'wpdb' ];

		$testee = new MySqlTableLookup(
			new Db\WpDbAdapter( $wpdb )
		);
		$table_mock = Mockery::mock( Table::class );
		$table_mock->shouldReceive( '__toString' )
			->andReturn( $wpdb->posts . '_lao0ciechae9aelaePhied1k' );
		$table_mock->shouldReceive( 'name' )
			->andReturn( $wpdb->posts . '_lao0ciechae9aelaePhied1k' );

		$this->assertFalse(
			$testee->table_exists( $table_mock )
		);
	}
}
