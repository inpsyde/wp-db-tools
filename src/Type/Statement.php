<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

/**
 * Interface Statement
 *
 * A SQL statement (a query that needs to be »prepared«).
 *
 * @package WpDbTypes\Type
 */
interface Statement {

	/**
	 * @return string
	 */
	public function statement();

	/**
	 * @return string
	 */
	public function __toString();
}