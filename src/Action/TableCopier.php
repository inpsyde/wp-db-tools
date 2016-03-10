<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTypes\Type;

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
	 * @param Type\Table $src
	 * @param Type\Table $dest
	 *
	 * @return bool
	 */
	public function copy( Type\Table $src, Type\Table $dest );

	/**
	 * Creates a new, empty table with the same structure of the $src table
	 *
	 * @param Type\Table $src
	 * @param Type\Table $dest
	 *
	 * @return bool
	 */
	public function copy_structure( Type\Table $src, Type\Table $dest );
}