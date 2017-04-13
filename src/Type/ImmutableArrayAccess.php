<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

use ArrayAccess;
use LogicException;

/**
 * Interface ImmutableArrayAccess
 *
 * Read-only array access to objects. Throws LogicException when trying to
 * write or unset a value
 *
 * @package WpDbTypes\Type
 */
interface ImmutableArrayAccess extends ArrayAccess {

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 *
	 * @throws LogicException
	 *
	 * @return void
	 */
	public function offsetSet( $offset, $value );

	/**
	 * @param mixed $offset
	 *
	 * @throws LogicException
	 *
	 * @return void
	 */
	public function offsetUnset( $offset );
}