<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Type;

/**
 * Class NamedTable
 *
 * @package WpDbTypes\Type
 */
class GenericTable implements Table {

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @param string $name
	 */
	public function __construct( $name ) {

		$this->name = (string) $name;
	}

	/**
	 * @return string
	 */
	public function name() {

		return $this->name;
	}

	/**
	 * @return string
	 */
	public function __toString() {

		return $this->name;
	}
}