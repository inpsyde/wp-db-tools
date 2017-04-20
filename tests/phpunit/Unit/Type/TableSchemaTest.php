<?php # -*- coding: utf-8 -*-

namespace WpDbTypes\Type;

use MonkeryTestCase\BrainMonkeyWpTestCase;

/**
 * Class TableSchemaTest
 *
 * @package WpDbTypes\Type
 */
class TableSchemaTest extends BrainMonkeyWpTestCase {

	/**
	 * Test if the interface is detected by the auto loader config
	 */
	public function test_interface_exists() {

		$this->assertSame(
			__NAMESPACE__ . '\TableSchema',
			TableSchema::class
		);
	}
}
