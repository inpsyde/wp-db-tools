<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

/**
 * Class ArbitraryStatement
 *
 * @package WpDbTypes\Type
 */
class GenericStatement implements Statement {

	/**
	 * @var string
	 */
	private $statement;

	/**
	 * @param string $statement
	 */
	public function __construct( $statement ) {

		$this->statement = (string) $statement;
	}

	/**
	 * @return string
	 */
	public function statement() {

		return $this->statement;
	}

	/**
	 * @return string
	 */
	public function __toString() {

		return $this->statement;
	}
}