<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	WpDbTypes\Type;

/**
 * Class MySqlTableCreator
 *
 * @package WpDbTools\Action
 */
class MySqlTableCreator implements TableCreator {

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
	 * @param Type\TableSchema $table_structure
	 *
	 * @return bool
	 */
	public function create_table( Type\TableSchema $table_structure ) {
		// TODO: Implement create_table() method.
	}

}