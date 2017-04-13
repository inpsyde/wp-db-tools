<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

use MonkeryTestCase;
use stdClass;

/**
 * Class GenericResultTest
 *
 * @package WpDbTypes\Type
 */
class GenericResultTest extends MonkeryTestCase\TestCase {

	/**
	 * @covers GenericResult::offsetGet
	 */
	public function test_array_access_read() {

		$data = [
			'db' => 'wpdb',
		];

		$testee = new GenericResult( $data );

		$this->assertSame(
			$data[ 'db' ],
			$testee[ 'db' ]
		);
	}

	/**
	 * @covers GenericResult::offsetExists
	 */
	public function test_array_access_isset() {

		$data = [
			'db' => 'wpdb',
		];

		$testee = new GenericResult( $data );

		$this->assertTrue(
			isset( $testee[ 'db' ] )
		);

		$this->assertFalse(
			isset( $testee[ 'wpdb' ] )
		);
	}

	/**
	 * @covers GenericResult::offsetSet
	 */
	public function test_array_access_write_exception() {

		$this->setExpectedException( 'LogicException' );

		$testee = new GenericResult( [] );
		$testee[ 'set' ] = 'value';
	}

	/**
	 * @covers GenericResult::offsetUnset
	 */
	public function test_array_access_unset_exception() {

		$this->setExpectedException( 'LogicException' );

		$testee = new GenericResult( [ 'test' => 'value' ] );
		unset( $testee[ 'test' ] );
	}

	/**
	 * @covers GenericResult::contains
	 */
	public function test_contains() {

		$included_object = new stdClass;
		$excluded_object = new stdClass;

		$testee = new GenericResult( [ $included_object ] );

		$this->assertTrue(
			$testee->contains( $included_object )
		);
		$this->assertFalse(
			$testee->contains( $excluded_object )
		);
	}
}
