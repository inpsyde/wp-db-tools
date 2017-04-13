<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

use	MonkeryTestCase;

/**
 * Class ArbitraryStatementTest
 *
 * @package WpDbTypes\Type
 */
class ArbitraryStatementTest extends MonkeryTestCase\TestCase {

	/**
	 * @covers ArbitraryStatement::statement
	 */
	public function test_contains() {

		$string = "SELECT * FROM TABLE WHERE `colum` LIKE '%Übertest%'";
		$testee = new ArbitraryStatement( $string );

		$this->assertSame(
			$string,
			$testee->statement()
		);
	}
}
