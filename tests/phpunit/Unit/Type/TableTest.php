<?php # -*- coding: utf-8 -*-

namespace WpDbTypes\Type;

use MonkeryTestCase;

/**
 * Class TableTest
 *
 * @package WpDbTypes\Type
 */
class TableTest extends MonkeryTestCase\TestCase {

	/**
	 * Test if the interface is detected by the auto loader config
	 */
	public function test_interface_exists() {

		$this->assertSame(
			__NAMESPACE__ . '\Table',
			Table::class
		);
	}
}
