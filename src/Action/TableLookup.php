<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use WpDbTools\Type\Table;

/**
 * Interface TableLookup
 *
 * Describes an action to lookup for an existing MySQL table
 *
 * @package WpDbTools\Action
 */
interface TableLookup {

	/**
	 * @param Table $table
	 *
	 * @return bool
	 */
	public function table_exists( Table $table );
}