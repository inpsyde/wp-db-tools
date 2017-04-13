<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use WpDbTools\Db\Database;
use WpDbTools\Type\TableSchema;

/**
 * Class MySqlTableCreator
 *
 * @package WpDbTools\Action
 */
class MySqlTableCreator implements TableCreator {

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
	 * @param TableSchema $table_structure
	 *
	 * @return bool
	 */
	public function create_table( TableSchema $table_structure ) {
		// TODO: Implement create_table() method.
	}

}