<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

use MonkeryTestCase;

/**
 * Class NamedTableTest
 *
 * @package WpDbTypes\Type
 */
class NamedTableTest extends MonkeryTestCase\TestCase {

	/**
	 * @covers NamedTable::name
	 */
	public function test_name() {

		$name = 'übertable';
		$testee = new NamedTable( $name );

		$this->assertSame(
			$name,
			$testee->name()
		);
	}
}
