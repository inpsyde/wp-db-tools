<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use	WpDbTools\Db\Database;
use Mockery;
use MonkeryTestCase\BrainMonkeyWpTestCase;

/**
 * Class MySqlTableCopierTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableCopierTest extends BrainMonkeyWpTestCase {

	public function test_copy() {

		$adapter_mock = Mockery::mock( Database::class );
		$testee = new MySqlTableCopier( $adapter_mock );

		$this->markTestSkipped( 'Under construction…' );
	}
}
