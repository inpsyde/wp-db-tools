<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

use	ArrayIterator;
use LogicException;

/**
 * Class GenericResult
 *
 * Alias of ArrayIterator. This is just a first and quick approach.
 *
 * DO NOT RELY ON ANY METHODS that are not part of Result but
 * part of ArrayIterator. You should always type-hint for Type\Result,
 * never for a concrete implementation.
 *
 * @package WpDbTypes\Type
 */
class GenericResult extends ArrayIterator implements Result {

	/**
	 * @param mixed $element
	 *
	 * @return bool
	 */
	public function contains( $element ) {

		return in_array(
			$element,
			$this->getArrayCopy(),
			TRUE
		);
	}

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 *
	 * @throws LogicException
	 * @return void
	 */
	public function offsetSet( $offset, $value ) {

		$class = __CLASS__;
		throw new LogicException( "Cannot override key '{$offset}' for immutable object of type {$class}" );
	}

	/**
	 * @param mixed $offset
	 *
	 * @throws LogicException
	 * @return void
	 */
	public function offsetUnset( $offset ) {

		$class = __CLASS__;
		throw new LogicException( "Cannot override key '{$offset}' for immutable object of type {$class}" );
	}
}