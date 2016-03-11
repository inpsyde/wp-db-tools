<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	wpdb,
	WP_UnitTestCase;

/**
 * Class MySqlTableLookupTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableLookupTest extends WP_UnitTestCase {

	public function test_table_exists() {

		/** @var wpdb $wpdb */
		$wpdb = $GLOBALS[ 'wpdb' ];

		$testee = new MySqlTableLookup(
			new Db\WpDbAdapter( $wpdb )
		);

		$this->assertTrue(
			$testee->table_exists( $wpdb->posts )
		);
	}
	public function test_not_table_exists() {

		/** @var wpdb $wpdb */
		$wpdb = $GLOBALS[ 'wpdb' ];

		$testee = new MySqlTableLookup(
			new Db\WpDbAdapter( $wpdb )
		);

		$this->assertFalse(
			$testee->table_exists( $wpdb->posts . '_lao0ciechae9aelaePhied1k' )
		);
	}
}
