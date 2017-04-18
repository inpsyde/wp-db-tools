<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

use MonkeryTestCase;

/**
 * Class NamedTableTest
 *
 * @package WpDbTypes\Type
 */
class GenericTableTest extends MonkeryTestCase\TestCase {

	/**
	 * @covers GenericTable::name
	 */
	public function test_name() {

		$name = 'übertable';
		$testee = new GenericTable( $name );

		$this->assertSame(
			$name,
			$testee->name()
		);
	}
}
