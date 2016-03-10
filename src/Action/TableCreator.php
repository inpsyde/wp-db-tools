<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTypes\Type;

/**
 * Interface TableCreator
 *
 * Describes an action to create a MySQL table along a TableSchema
 *
 * @package Action
 */
interface TableCreator {

	/**
	 * @param Type\TableSchema $table_structure
	 *
	 * @return bool
	 */
	public function create_table( Type\TableSchema $table_structure );
}