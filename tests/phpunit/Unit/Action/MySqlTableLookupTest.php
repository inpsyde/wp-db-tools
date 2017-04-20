<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use MonkeryTestCase\BrainMonkeyWpTestCase;
use	WpDbTools\Db\Database;
use Mockery;

/**
 * Class MySqlTableLookupTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableLookupTest extends BrainMonkeyWpTestCase  {

	public function test_table_exists() {

		$adapter_mock = Mockery::mock( Database::class );
		$testee = new MySqlTableLookup( $adapter_mock );

		$this->markTestSkipped( 'Under construction…' );
	}
}
