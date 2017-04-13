<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use WpDbTools\Type\Table;

/**
 * Interface TableCopier
 *
 * Describes the action to copy a MySQL table
 *
 * @package WpDbTools\Action
 */
interface TableCopier {

	/**
	 * Duplicates a table structure with the complete content
	 *
	 * @param Table $src
	 * @param Table $dest
	 *
	 * @return bool
	 */
	public function copy( Table $src, Table $dest );

	/**
	 * Creates a new, empty table with the same structure of the $src table
	 *
	 * @param Table $src
	 * @param Table $dest
	 *
	 * @return bool
	 */
	public function copy_structure( Table $src, Table $dest );
}