<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

/**
 * Interface Table
 *
 * @package WpDbTypes\Type
 */
interface Table {

	/**
	 * Complete table name (including any prefix)
	 *
	 * @return string
	 */
	public function name();

	/**
	 * @return string
	 */
	public function __toString();
}