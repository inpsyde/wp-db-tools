<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	WpDbTypes\Type;

/**
 * Class MySqlTableLookup
 *
 * @package WpDbTools\Action
 */
class MySqlTableLookup implements TableLookup {

	/**
	 * @var Db\Database
	 */
	private $database;

	/**
	 * @param Db\Database $database
	 */
	public function __construct( Db\Database $database ) {

		$this->database = $database;
	}

	/**
	 * @param string $table
	 *
	 * @return bool
	 */
	public function table_exists( $table ) {

		$statement = new Type\ArbitraryStatement( "SHOW TABLES LIKE %s" );
		$result = $this->database
			->query_statement( $statement, [ $table ] );

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