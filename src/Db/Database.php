<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Db;

use WpDbTools\Type\Statement;
use WpDbTools\Type\Result;

/**
 * Interface to the database
 *
 * @package WpDbTools\Db
 */
interface Database {

	/**
	 * Executes a plain SQL query and return the results.
	 *
	 * @see query_statement for queries containing user input!
	 *
	 * @param $query
	 * @param int $options
	 *
	 * @return Result
	 */
	public function query( $query, $options = 0 );

	/**
	 * Executes a Statement and return a Result
	 *
	 * @param Statement $statement
	 * @param array $data
	 * @param int $options (Optional)
	 *
	 * @return Result
	 */
	public function query_statement( Statement $statement, array $data, $options = 0 );

	/**
	 * Executes a Statement and return the number of affected rows
	 *
	 * @param Statement $statement
	 * @param array $data
	 * @param int $options (Optional)
	 *
	 * @return int
	 */
	public function execute_statement( Statement $statement, array $data, $options = 0 );

	/**
	 * Returns the inserted ID of the last executed statement. If a statement
	 * is provided it should be verified that it is the same as the last executed one.
	 *
	 * @param Statement $statement (Optional)
	 *
	 * @return int|false
	 */
	public function last_insert_id( Statement $statement = NULL );

	/**
	 * Returns the number of affected rows of the last executed statement.
	 * If a statement is provided it should be verified that it is the same
	 * as the last executed one.
	 *
	 * @param Statement $statement (Optional)
	 *
	 * @return mixed
	 */
	public function last_affected_rows( Statement $statement = NULL );

	/**
	 * @param string $string
	 *
	 * @return string
	 */
	public function quote_string( $string );

	/**
	 * Escaping identifiers
	 * http://us3.php.net/manual/en/pdo.quote.php#112169
	 *
	 * @param $identifier
	 *
	 * @return string
	 */
	public function quote_identifier( $identifier );
}