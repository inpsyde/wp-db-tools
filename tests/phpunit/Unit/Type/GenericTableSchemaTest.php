<?php # -*- coding: utf-8 -*-

namespace WpDbTypes\Type;

use MonkeryTestCase\BrainMonkeyWpTestCase;
use WpDbTools\Exception\Type\InvalidTableSchema;
use WpDbTools\Type\GenericTableSchema;

class GenericTableSchemaTest extends BrainMonkeyWpTestCase {

	public function test_name() {

		$definition = [
			'name' => 'my_table',
			'schema' => [
				'id' => [
					'name' => 'id',
					'description' => "BIGINT(20)",
				],
			],
		];

		$testee = new GenericTableSchema( $definition );

		$this->assertSame(
			$definition[ 'name' ],
			$testee->name()
		);
	}

	public function test_schema() {

		$definition = [
			'name' => 'my_table',
			'schema' => [
				'id' => [
					'name' => 'id',
					'description' => "BIGINT(20)",
				],
			],
		];

		$testee = new GenericTableSchema( $definition );

		$this->assertSame(
			$definition[ 'schema' ],
			$testee->schema()
		);
	}

	public function test_primary_key() {

		$definition = [
			'name' => 'my_table',
			'schema' => [
				'id' => [
					'name' => 'id',
					'description' => "BIGINT(20)",
				],
			],
			'primary_key' => [
				'id',
			],
		];

		$testee = new GenericTableSchema( $definition );

		$this->assertSame(
			$definition[ 'primary_key' ],
			$testee->primary_key()
		);
	}

	public function test_indices() {

		$definition = [
			'name' => 'my_table',
			'schema' => [
				'id' => [
					'name' => 'id',
					'description' => "BIGINT(20)",
				],
			],
			'indices' => [
				'id' => [
					'name' => 'id',
					'description' => "KEY id (id)",
				],
			],
		];

		$testee = new GenericTableSchema( $definition );

		$this->assertSame(
			$definition[ 'indices' ],
			$testee->indices()
		);
	}

	/**
	 * @dataProvider exceptions_on_invalid_schema_data
	 *
	 * @param array $definition
	 */
	public function test_exceptions_on_invalid_schema( array $definition ) {

		$this->expectException(
			InvalidTableSchema::class
		);

		new GenericTableSchema( $definition );
	}

	/**
	 * @see test_exceptions_on_invalid_schema
	 * @return array
	 */
	public function exceptions_on_invalid_schema_data() {

		return [
			'missing_name' => [
				'schema' => [
					'id' => [
						'name' => 'id',
						'description' => 'BIGINT(20)',
					],
				],
			],
			'name_is_not_string' => [
				[
					'name' => 3.15159,
					'schema' => [
						'id' => [
							'name' => 'id',
							'description' => 'BIGINT(20)',
						],
					],
				],
			],
			'missing_schema' => [
				[
					'name' => 'my_table',
				],
			],
			'schema_is_not_array' => [
				[
					'name' => 'my_table',
					'schema' => false,
				],
			],
			'schema_keys_not_string' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id', 'title' ],
				],
			],
			'schema_values_not_array' => [
				[
					'name' => 'my_table',
					'schema' => [
						'id' => false,
						'title' => 3,
					],
				],
			],
			'schema_column_name_missing' => [
				[
					'name' => 'my_table',
					'schema' => [
						'id' => [
							'description' => 'foo',
						],
					],
				],
			],
			'schema_column_description_missing' => [
				[
					'name' => 'my_table',
					'schema' => [
						'id' => [
							'name' => 'foo',
						],
					],
				],
			],
			'primary_key_not_array' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'primary_key' => false,
				],
			],
			'primary_key_missing_column' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'primary_key' => [ 'title' ],
				],
			],
			'primary_key_not_contains_strings' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'primary_key' => [ false ],
				],
			],
			'indices_not_array' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'indices' => 4,
				],
			],
			'indices_key_not_string' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'indices' => [ 'KEY id(20)' ],
				],
			],
			'indices_value_not_string' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'indices' => [ 'id' => 'KEY id(20)' ],
				],
			],
			'indices_missing_name' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'indices' => [
						'id' => [
							'description' => 'KEY id(20)',
						],
					],
				],
			],
			'indices_missing_description' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'indices' => [
						'id' => [
							'name' => 'id',
						],
					],
				],
			],
			'indices_name_is_not_string' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'indices' => [
						'id' => [
							'name' => 123,
							'description' => 'KEY id(20)',
						],
					],
				],
			],
			'indices_description_is_not_string' => [
				[
					'name' => 'my_table',
					'schema' => [ 'id' => [ 'name' => 'id', 'description' => 'BIGINT(20)' ] ],
					'indices' => [
						'id' => [
							'name' => 'od',
							'description' => 20,
						],
					],
				],
			],
		];
	}
}
