<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Factory;

use Symfony\Component\Yaml\Yaml;
use WpDbTools\Exception\RuntimeException;
use WpDbTools\Exception\Type\InvalidTableSchema;
use WpDbTools\Type\GenericTableSchema;
use WpDbTools\Type\TableSchema;
use wpdb;

/**
 * Class TableSchemaFactory
 *
 * @package WpDbTools\Factory
 */
class TableSchemaFactory {

	private $network_prefix;

	private $site_prefix;

	public function __construct( wpdb $wpdb ) {

		$this->network_prefix = $wpdb->base_prefix;
		$this->site_prefix = $wpdb->prefix;
	}

	/**
	 * @param string $yaml
	 *
	 * @return TableSchema
	 */
	public function create_from_yaml( $yaml ) {

		$definition = Yaml::parse( $yaml )[ 'table' ];

		if ( array_key_exists( 'prefix', $definition ) ) {
			$definition[ 'base_name' ] = $definition[ 'name' ];
			$definition[ 'name' ] = $this->apply_prefix( $definition[ 'prefix' ], $definition[ 'name' ] );
			unset( $definition[ 'prefix' ] );
		}

		return new GenericTableSchema( $definition );
	}

	/**
	 * @param string $file
	 *
	 * @return TableSchema
	 */
	public function create_from_yaml_file( $file ) {

		return $this->create_from_yaml( file_get_contents( $file ) );
	}

	/**
	 * Dynamic method to fetch a new instance from the current global state
	 *
	 * @return TableSchemaFactory
	 */
	public function with_globals() {

		return self::from_globals();
	}

	/**
	 * @throws RuntimeException
	 * @return TableSchemaFactory
	 */
	public static function from_globals() {

		if ( empty( $GLOBALS[ 'wpdb' ] ) || ! $GLOBALS[ 'wpdb' ] instanceof wpdb ) {
			throw new RuntimeException( "Global \$wpdb not type of wpdb" );
		}

		return new self( $GLOBALS[ 'wpdb' ] );
	}

	/**
	 * @param $prefix_type
	 * @param $name
	 *
	 * @return string
	 * @throws InvalidTableSchema
	 */
	private function apply_prefix( $prefix_type, $name ) {

		switch( $prefix_type ) {
			case 'network' :
				return $this->network_prefix . $name;
			case 'site' :
				return $this->site_prefix . $name;
		}

		throw new InvalidTableSchema( "Unknown prefix type: {$prefix_type}" );
	}
}