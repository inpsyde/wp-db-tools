<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

/**
 * Interface TableSchema
 *
 * @package WpDbTypes\Type
 */
interface TableSchema extends Table {

	/**
	 * Returns an array of colum_name => column description
	 *
	 * @return array
	 */
	public function schema();

	/**
	 * Name of the primary key column
	 *
	 * @return string
	 */
	public function primary_key();

	/**
	 * List of auto-increment / auto-filled columns
	 *
	 * @return array
	 */
	public function autofilled_keys();

	/**
	 * List of indices
	 *
	 * @return array
	 */
	public function indices();
}