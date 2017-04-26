<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Factory;

use MonkeryTestCase\BrainMonkeyWpTestCase;
use Mockery;
use WpDbTools\Exception\Type\InvalidTableSchema;

class TableSchemaFactoryTest extends BrainMonkeyWpTestCase {

	const NETWORK_PREFIX = 'wp_';
	const SITE_PREFIX = 'wp_2_';

	/**
	 * @dataProvider create_from_yaml_data
	 *
	 * @param string $yaml
	 * @param array $expected_schema
	 */
	public function test_create_from_yaml( $yaml, array $expected_schema ) {

		$wpdb_mock = $this->get_wpdb_mock();
		$testee = new TableSchemaFactory( $wpdb_mock );
		$schema = $testee->create_from_yaml( $yaml );

		$this->assertSame(
			$expected_schema[ 'name' ],
			$schema->name()
		);
		$this->assertSame(
			$expected_schema[ 'schema' ],
			$schema->schema()
		);
		$this->assertSame(
			$expected_schema[ 'primary_key' ],
			$schema->primary_key()
		);
		$this->assertSame(
			$expected_schema[ 'indices' ],
			$schema->indices()
		);
	}

	/**
	 * @see test_create_from_yaml
	 * @return array
	 */
	public function create_from_yaml_data() {

		$data = [];

		$yaml = <<<YAML
table:
  name: test_table
  prefix: network
  schema:
    id:
      name: id
      description: BIGINT NOT NULL
    title:
      name: title
      description: VARCHAR(255)
    slug:
      name: slug
      description: VARCHAR(255) NOT NULL
  primary_key:
    - id
  indices:
    unique_slug:
      name: slug
      description: UNIQUE %% (%id%)
YAML;

		$data[ 'network_prefix_multicolumn_unique_index' ] = [
			$yaml,
			[
				'name' => self::NETWORK_PREFIX . 'test_table',
				'schema' => [
					'id' => [
						'name' => 'id',
						'description' => 'BIGINT NOT NULL',
					],
					'title' => [
						'name' => 'title',
						'description' => 'VARCHAR(255)',
					],
					'slug' => [
						'name' => 'slug',
						'description' => 'VARCHAR(255) NOT NULL',
					],
				],
				'primary_key' => [ 'id' ],
				'indices' => [
					'unique_slug' => [
						'name' => 'slug',
						'description' => 'UNIQUE %% (%id%)',
					],
				],
			],
		];

		$yaml = <<<YAML
table:
  name: test_table
  prefix: site
  schema:
    id:
      name: id
      description: BIGINT NOT NULL
YAML;

		$data[ 'site_prefix_single_column' ] = [
			$yaml,
			[
				'name' => self::SITE_PREFIX . 'test_table',
				'schema' => [
					'id' => [
						'name' => 'id',
						'description' => 'BIGINT NOT NULL',
					],
				],
				'primary_key' => [],
				'indices' => [],
			],
		];


		$yaml = <<<YAML
table:
  name: test_table
  schema:
    id:
      name: id
      description: BIGINT NOT NULL
YAML;

		$data[ 'no_prefix_single_column' ] = [
			$yaml,
			[
				'name' => 'test_table',
				'schema' => [
					'id' => [
						'name' => 'id',
						'description' => 'BIGINT NOT NULL',
					],
				],
				'primary_key' => [],
				'indices' => [],
			],
		];

		return $data;
	}

	public function test_unknown_prefix_throws_exception() {

		$wpdb_mock = $this->get_wpdb_mock();

		$valid_schema = <<<YAML
table:
  name: test_table
  schema:
    id:
      name: id
      description: BIGINT NOT NULL
YAML;
		$invalid_prefix_schema = <<<YAML
table:
  name: test_table
  prefix: unknown
  schema:
    id:
      name: id
      description: BIGINT NOT NULL
YAML;

		$testee = new TableSchemaFactory( $wpdb_mock );
		$testee->create_from_yaml( $valid_schema ); // Should not throw an exception

		$this->expectException( InvalidTableSchema::class );
		$testee->create_from_yaml( $invalid_prefix_schema );
	}

	private function get_wpdb_mock() {

		$wpdb_mock = Mockery::mock( 'wpdb' );
		$wpdb_mock->base_prefix = self::NETWORK_PREFIX;
		$wpdb_mock->prefix = self::SITE_PREFIX;

		return $wpdb_mock;
	}
}
