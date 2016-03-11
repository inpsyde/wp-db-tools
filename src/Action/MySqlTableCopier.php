<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	WpDbTypes\Type;

/**
 * Class MySqlTableCopier
 *
 * @package WpDbTools\Action
 */
class MySqlTableCopier implements TableCopier {

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
	 * Duplicates a table structure with the complete content
	 *
	 * @param Type\Table $src
	 * @param Type\Table $dest
	 *
	 * @return bool
	 */
	public function copy( Type\Table $src, Type\Table $dest ) {

		$this->copy_structure( $src, $dest );
		$src_table  = $this->database->quote_identifier( $src->name() );
		$dest_table = $this->database->quote_identifier( $dest->name() );
		$query      = "INSERT INTO {$dest_table} SELECT * FROM {$src_table}";

		return (bool) $this->database->query( $query );
	}

	/**
	 * Creates a new, empty table with the same structure of the $src table
	 *
	 * @param Type\Table $src
	 * @param Type\Table $dest
	 *
	 * @return bool
	 */
	public function copy_structure( Type\Table $src, Type\Table $dest ) {

		$src_table  = $this->database->quote_identifier( $src->name() );
		$dest_table = $this->database->quote_identifier( $dest->name() );
		$statement  = new Type\ArbitraryStatement(
			"CREATE TABLE {$dest_table} LIKE {$src_table}"
		);

		// this will always return 0 even on error
		$this->database->query( $statement );

		return TRUE;
	}

}