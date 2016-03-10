<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Db;

use
	WpDbTypes\Type,
	WpPreparedStatementsConverter\Converter,
	wpdb;

/**
 * Class WpDbAdapter
 *
 * A adapter that works with the wpdb style syntax of »prepared statemens«
 * that is actually a sprintf syntax
 * "SELECT * FROM `wp_posts` WHERE `post_name` LIKE %s"
 *
 * @package WpDbTools\Db
 */
class WpDbAdapter implements Database {

	/**
	 * @var wpdb
	 */
	private $wpdb;

	/**
	 * @var Type\Statement
	 */
	private $last_statement;

	/**
	 * @var int
	 */
	private $last_affected_rows = 0;

	/**
	 * @var int
	 */
	private $last_insert_id = 0;

	/**
	 * @param wpdb $wpdb
	 */
	public function __construct( wpdb $wpdb ) {

		$this->wpdb = $wpdb;
	}

	/**
	 * Executes a plain SQL query and return the results
	 *
	 * @param $query
	 * @param int $options
	 *
	 * @return Type\Result
	 */
	public function query( $query, $options = 0 ) {

		$result                   = $this->wpdb->get_results( (string) $query );
		$this->last_affected_rows = (int) $this->wpdb->rows_affected;
		$this->last_insert_id     = (int) $this->wpdb->insert_id;
		$this->last_statement     = NULL;
		if ( ! is_array( $result ) )
			$result = [];

		return new Type\GenericResult( $result );
	}

	/**
	 * Executes a Statement and return a Result
	 *
	 * @param Type\Statement $statement
	 * @param array $data (Optional)
	 * @param int $options (Optional)
	 *
	 * @return Type\Result
	 */
	public function query_statement( Type\Statement $statement, array $data = [ ], $options = 0 ) {

		// @todo maybe convert statement in a decorator
		$query                    = $this->wpdb->prepare( (string) $statement, $data );
		$result                   = $this->query( $query );
		$this->last_statement     = $statement;

		return $result;
	}

	/**
	 * Executes a Statement and return the number of affected rows
	 *
	 * @param Type\Statement $statement
	 * @param array $data (Optional)
	 * @param int $options (Optional)
	 *
	 * @return int
	 */
	public function execute_statement( Type\Statement $statement, array $data = [ ], $options = 0 ) {

		$this->query_statement( $statement, $data, $options );

		return $this->last_affected_rows();
	}

	/**
	 * Returns the inserted ID of the last executed statement. If a statement
	 * is provided it should be verified that it is the same as the last executed one.
	 *
	 * @param Type\Statement $statement (Optional)
	 *
	 * @return int|false
	 */
	public function last_insert_id( Type\Statement $statement = NULL ) {

		if ( $statement && ! $this->last_statement === $statement )
			return FALSE;

		return $this->last_insert_id;
	}

	/**
	 * Returns the number of affected rows of the last executed statement.
	 * If a statement is provided it should be verified that it is the same
	 * as the last executed one.
	 *
	 * @param Type\Statement $statement (Optional)
	 *
	 * @return mixed
	 */
	public function last_affected_rows( Type\Statement $statement = NULL ) {

		if ( $statement && ! $this->last_statement === $statement )
			return FALSE;

		return $this->last_affected_rows;
	}

	/**
	 * @param string $string
	 *
	 * @return string
	 */
	public function quote_string( $string ) {

		return "'" . esc_sql( $string ) . "'";
	}

	/**
	 * Escaping identifiers
	 * http://us3.php.net/manual/en/pdo.quote.php#112169
	 *
	 * @param $identifier
	 *
	 * @return string
	 */
	public function quote_identifier( $identifier ) {

		$identifier = str_replace( '`', '``', $identifier );

		return "`{$identifier}`";
	}

}