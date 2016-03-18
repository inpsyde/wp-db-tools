<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use
	WpDbTypes\Type;

/**
 * Interface TableEraser
 *
 * @package WpDbTools\Action
 */
interface TableEraser {

	/**
	 * @param string|Type\Table $table
	 *
	 * @return void
	 */
	public function drop_table( $table );
}