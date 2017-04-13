<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

use	Countable;
use Iterator;

/**
 * Interface Result
 *
 * Immutable list of database records (results)
 *
 * @package WpDbTypes\Type
 */
interface Result extends ImmutableArrayAccess, Countable, Iterator  {

	/**
	 * @param mixed $element
	 *
	 * @return bool
	 */
	public function contains( $element );
}