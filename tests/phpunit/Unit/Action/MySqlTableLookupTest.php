<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	Brain,
	Mockery,
	MonkeryTestCase;

/**
 * Class MySqlTableLookupTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableLookupTest extends MonkeryTestCase\TestCase {

	public function test_table_exists() {

		$adapter_mock = Mockery::mock( Db\Database::class );
		$testee = new MySqlTableLookup( $adapter_mock );

		$this->markTestSkipped( 'Under construction…' );
	}
}
