<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTools\Db,
	WpDbTypes\Type;

/**
 * Class MySqlTableEraser
 *
 * @package WpDbTools\Action
 */
class MySqlTableEraser implements TableEraser {

	/**
	 * @var Db\Database
	 */
	private $db;

	/**
	 * @param Db\Database $db
	 */
	public function __construct( Db\Database $db ) {

		$this->db = $db;
	}

	/**
	 * @param string|Type\Table $table
	 *
	 * @return void
	 */
	public function drop_table( $table ) {

		$table = $this->db->quote_identifier( (string) $table );
		$query = "DROP TABLE IF EXISTS {$table}";
		$this->db->query( $query );
	}

}