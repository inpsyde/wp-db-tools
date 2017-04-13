<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use WpDbTools\Db\Database;
use WpDbTools\Type\ArbitraryStatement;
use WpDbTools\Type\Table;

/**
 * Class MySqlTableLookup
 *
 * @package WpDbTools\Action
 */
class MySqlTableLookup implements TableLookup {

	/**
	 * @var Database
	 */
	private $database;

	/**
	 * @param Database $database
	 */
	public function __construct( Database $database ) {

		$this->database = $database;
	}

	/**
	 * @param Table $table
	 *
	 * @return bool
	 */
	public function table_exists( Table $table ) {

		$statement = new ArbitraryStatement( "SHOW TABLES LIKE %s" );
		$result = $this->database
			->query_statement( $statement, [ (string) $table ] );

		if ( ! $result->valid() )
			return FALSE;

		/**
		 * @todo refactor this as soon as
		 * we have unified options bit-mask implemented
		 * to get results in single-level arrays
		 *
		 * return $result->contains( $table );
		 */

		$tables = [];
		foreach ( $result as $row ) {
			$tables = array_merge(
				$tables,
				array_values(
					get_object_vars( $row )
				)
			);
		}
		return in_array( $table, $tables );
	}
}