<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db;

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

		$statement = $this->database
			->prepare( "SHOW TABLES LIKE %s" );
		$result = $this->database
			->query_statement( $statement, [ $table ] );

		if ( ! $result->valid() )
			return FALSE;

		return $result->contains( $table );
	}
}