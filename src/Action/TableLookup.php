<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

/**
 * Interface TableLookup
 *
 * Describes an action to lookup for an existing MySQL table
 *
 * @package WpDbTools\Action
 */
interface TableLookup {

	/**
	 * @param string $table
	 *
	 * @return bool
	 */
	public function table_exists( $table );
}