<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

/**
 * Interface TableSchema
 *
 * @package WpDbTypes\Type
 */
interface TableSchema extends Table {

	/**
	 * Returns a list of column_name => column description
	 *
	 * @return string[]
	 */
	public function schema();

	/**
	 * Name of the primary key columns
	 *
	 * @return string[]
	 */
	public function primary_key();

	/**
	 * Returns a list of index_name => index_description
	 *
	 * @return string[]
	 */
	public function indices();
}