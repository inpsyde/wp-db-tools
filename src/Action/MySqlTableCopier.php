<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use WpDbTools\Db\Database;
use WpDbTools\Type\Table;

/**
 * Class MySqlTableCopier
 *
 * @package WpDbTools\Action
 */
class MySqlTableCopier implements TableCopier {

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
	 * Duplicates a table structure with the complete content
	 *
	 * @param Table $src
	 * @param Table $dest
	 *
	 * @return bool
	 */
	public function copy( Table $src, Table $dest ) {

		$this->copy_structure( $src, $dest );
		$src_table  = $this->database->quote_identifier( $src->name() );
		$dest_table = $this->database->quote_identifier( $dest->name() );
		$query      = "INSERT INTO {$dest_table} SELECT * FROM {$src_table}";

		return (bool) $this->database->query( $query );
	}

	/**
	 * Creates a new, empty table with the same structure of the $src table
	 *
	 * @param Table $src
	 * @param Table $dest
	 *
	 * @return bool
	 */
	public function copy_structure( Table $src, Table $dest ) {

		$src_table  = $this->database->quote_identifier( $src->name() );
		$dest_table = $this->database->quote_identifier( $dest->name() );
		$statement  = new \WpDbTools\Type\GenericStatement(
			"CREATE TABLE {$dest_table} LIKE {$src_table}"
		);

		// this will always return 0 even on error
		$this->database->query( $statement );

		return TRUE;
	}

}