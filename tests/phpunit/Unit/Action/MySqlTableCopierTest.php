<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	Brain,
	Mockery,
	MonkeryTestCase;

/**
 * Class MySqlTableCopierTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableCopierTest extends MonkeryTestCase\TestCase {

	public function test_copy() {

		$adapter_mock = Mockery::mock( Db\Database::class );
		$testee = new MySqlTableCopier( $adapter_mock );

		$this->markTestSkipped( 'Under construction…' );
	}
}
