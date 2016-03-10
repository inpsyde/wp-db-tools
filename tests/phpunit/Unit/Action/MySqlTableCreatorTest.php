<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	Brain,
	Mockery,
	MonkeryTestCase;

/**
 * Class MySqlTableCreatorTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableCreatorTest extends MonkeryTestCase\TestCase {

	public function test_create_table() {

		$database_mock = Mockery::mock( Db\Database::class );
		$testee = new MySqlTableCreator( $database_mock );

		$this->markTestSkipped( 'Under construction…' );
	}
}
