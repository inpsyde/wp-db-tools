<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

/**
 * Interface TableSchema
 *
 * @package WpDbTypes\Type
 */
interface TableSchema extends Table {

	/**
	 * Returns a list of [ id => [ name => <column_name>, description => <column_description> ], ... ]
	 *
	 * @return array[]
	 */
	public function schema();

	/**
	 * Name of the primary key columns
	 *
	 * @return string[]
	 */
	public function primary_key();

	/**
	 * Returns a list of [ id => [ name => <index_name>, description => <index_description> ], ... ]
	 *
	 * @return array[]
	 */
	public function indices();
}