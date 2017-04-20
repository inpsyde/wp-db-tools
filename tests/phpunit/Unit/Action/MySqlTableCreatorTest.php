<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use MonkeryTestCase\BrainMonkeyWpTestCase;
use WpDbTools\Db\Database;
use Mockery;

/**
 * Class MySqlTableCreatorTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableCreatorTest extends BrainMonkeyWpTestCase {

	public function test_create_table() {

		$database_mock = Mockery::mock( Database::class );
		$testee = new MySqlTableCreator( $database_mock );

		$this->markTestSkipped( 'Under construction…' );
	}
}
