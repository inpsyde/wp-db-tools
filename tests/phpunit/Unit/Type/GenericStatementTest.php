<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

use	MonkeryTestCase;

/**
 * Class ArbitraryStatementTest
 *
 * @package WpDbTypes\Type
 */
class GenericStatementTest extends MonkeryTestCase\TestCase {

	/**
	 * @covers GenericStatement::statement
	 */
	public function test_contains() {

		$string = "SELECT * FROM TABLE WHERE `colum` LIKE '%Übertest%'";
		$testee = new GenericStatement( $string );

		$this->assertSame(
			$string,
			$testee->statement()
		);
	}
}
