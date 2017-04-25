<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use WpDbTools\Db\Database;
use WpDbTools\Exception\Type\InvalidTableSchema;
use WpDbTools\Type\TableSchema;

/**
 * Class MySqlTableCreator
 *
 * @package WpDbTools\Action
 */
class MySqlTableCreator implements TableCreator {

	const IF_NOT_EXISTS = 0b0001;
	const TEMPORARY = 0b0010;

	/**
	 * @var Database
	 */
	private $database;

	/**
	 * @var int
	 */
	private $options = 0;

	/**
	 * @param Database $database
	 * @param int $options
	 */
	public function __construct( Database $database, $options = 0 ) {

		$this->database = $database;
		$this->options = (int) $options;
	}

	/**
	 * @param TableSchema $schema
	 *
	 * @return bool
	 */
	public function create_table( TableSchema $schema ) {

		$sql = <<<SQL
CREATE {$this->temporary()}TABLE {$this->if_not_exists()}{$this->table_name( $schema )} (
	{$this->table_schema( $schema )}
	{$this->primary_key( $schema )}
	{$this->indices( $schema )}
);
SQL;

		return $this->database->execute( $sql );

	}

	private function table_name( TableSchema $schema ) {

		return $this->database->quote_identifier( $schema->name() );
	}

	private function table_schema( TableSchema $schema ) {

		$columns = $schema->schema();
		array_walk( $columns, function( &$col ) {
			$col = $this->database->quote_identifier( $col[ 'name' ] ) . ' ' . $col[ 'definition' ];
		} );

		return implode( ",\n\t", $columns );
	}

	private function primary_key( TableSchema $schema ) {

		if ( empty( $schema->primary_key() ) ) {
			return '';
		}

		$primary_keys = [];
		$columns = $schema->schema();
		if ( $mismatch = array_diff( $schema->primary_key(), array_keys( $columns ) ) ) {
			throw new InvalidTableSchema( "Primary keys not matching column definitions: " . implode( ',', $mismatch ) );
		}

		array_walk( $columns, function( $col, $id ) use ( $schema, &$primary_keys ) {
			if ( ! in_array( $id, $schema->primary_key() ) ) {
				return;
			}
			$primary_keys[] = $this->database->quote_identifier( $col[ 'name' ] );
		} );

		return ! empty( $primary_keys )
			? ", PRIMARY KEY (" . implode(',', $primary_keys) . ")"
			: '';
	}

	private function indices( TableSchema $schema ) {

		$definitions = [];
		$indices = $schema->indices();
		array_walk( $indices, function( $index, $id ) use ( $schema, &$definitions ) {
			$name = $this->database->quote_identifier( $index[ 'name' ] );
			$definition = $this->mb_replace( '%%', $name, $index[ 'definition' ] );
			$definition = $this->substitute_column_placeholders( $definition, $schema );
			$definitions[] = $definition;
		} );

		return ! empty( $definitions )
			? ", " . implode( ", ", $definitions )
			: '';
	}

	private function substitute_column_placeholders( $definition, TableSchema $schema ) {

		$columns = $schema->schema();
		array_walk( $columns, function( $column, $id ) use ( &$definition ) {
			$column_name = $this->database->quote_identifier( $column[ 'name' ] );
			$definition = $this->mb_replace( "%{$id}%", $column_name, $definition );
		} );

		return $definition;
	}

	private function mb_replace( $search, $replace, $string ) {

		$parts = mb_split( $search, $string );

		return implode( $replace, $parts );
	}

	private function if_not_exists() {

		return $this->options & self::IF_NOT_EXISTS
			? 'IF NOT EXISTS '
			: '';
	}

	private function temporary() {

		return $this->options & self::TEMPORARY
			? 'TEMPORARY '
			: '';
	}
}