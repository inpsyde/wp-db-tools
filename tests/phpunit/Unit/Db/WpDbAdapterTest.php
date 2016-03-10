<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Db;

use
	Brain,
	Mockery,
	MonkeryTestCase;

/**
 * Class WpDbAdapterTest
 *
 * @package WpDbTools\Db
 */
class WpDbAdapterTest extends MonkeryTestCase\TestCase {

	public function test_query() {

		$this->markTestSkipped( 'Under construction' );
	}

	public function test_query_statement() {

		$this->markTestSkipped( 'Under construction' );
	}

	public function test_execute_statement() {

		$this->markTestSkipped( 'Under construction' );
	}

	public function test_last_insert_id() {

		$this->markTestSkipped( 'Under construction' );
	}

	public function last_affected_rows() {

		$this->markTestSkipped( 'Under construction' );
	}

	public function esc_string() {

		$string = "'; DROP TABLE wp_users; --";
		$expected = "'\\'; DROP TABLE wp_users; --'";
		Brain\Monkey::functions()
			->expect( 'esc_sql' )
			->once()
			->with( $string )
			->andReturn( $expected );

		$testee = new WpDbAdapter( Mockery::mock( 'wpdb' ) );

		$this->assertSame(
			$expected,
			$testee->quote_identifier( $string )
		);
	}

	/**
	 * @dataProvider quote_identifier_test_data
	 *
	 * @param string $identifier
	 * @param string $expected
	 */
	public function test_quote_identifier( $identifier, $expected ) {

		$identifier = 'wp_posts';
		$expected   = "`{$identifier}`";
		$wpdb_mock = Mockery::mock( 'wpdb' );

		$testee = new WpDbAdapter( $wpdb_mock );

		$this->assertSame(
			$expected,
			$testee->quote_identifier( $identifier )
		);
	}

	/**
	 * @see test_quote_identifier
	 * @return array
	 */
	public function quote_identifier_test_data() {

		$data = [];

		$data[ 'test_1' ] = [
			#1. Parameter $identifier
			'wp_posts',
			#2. Parameter $expected
			'`wp_posts`'
		];

		$data[ 'test_2' ] = [
			#1. Parameter $identifier
			'wp_po`sts',
			#2. Parameter $expected
			'`wp_po``sts`'
		];

		$data[ 'test_3' ] = [
			#1. Parameter $identifier
			'wp_po``sts',
			#2. Parameter $expected
			'`wp_po````sts`'
		];

		return $data;
	}
}
