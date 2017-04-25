<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Test;

trait SqlTestUtils {

	public function normalize_sql_string( $sql ) {

		$sql = explode( "\n", trim( $sql ) );
		$sql = array_map( 'trim', $sql );
		$sql = array_filter( $sql, function( $el ) {
			return ! empty( $el );
		} );

		return implode( ' ', $sql );
	}
}