<?php # -*- coding: utf-8 -*-

namespace WpDbTools\Action;

use MonkeryTestCase\BrainMonkeyWpTestCase;
use WpDbTools\Db\Database;
use Mockery;
use WpDbTools\Test\SqlTestUtils;
use WpDbTools\Type\TableSchema;

/**
 * Class MySqlTableCreatorTest
 *
 * @package WpDbTools\Action
 */
class MySqlTableCreatorTest extends BrainMonkeyWpTestCase {

	use SqlTestUtils;

	/**
	 * @dataProvider create_table_data
	 *
	 * @param $table_data
	 * @param $options
	 * @param $expected_sql
	 */
	public function test_create_table( $table_data, $options, $expected_sql ) {

		$database_mock = Mockery::mock( Database::class );
		$database_mock->shouldReceive( 'quote_identifier' )
			->andReturnUsing(
				function( $identifier ) {

					return "`{$identifier}`";
				}
			);
		$database_mock->shouldReceive( 'execute' )
			->once()
			->andReturnUsing(
				function( $statement ) use ( $expected_sql ) {

					$this->assertSame(
						$expected_sql,
						$this->normalize_sql_string( $statement )
					);

					return true;
				}
			);

		$schema_mock = $this->build_table_schema( $table_data );

		$testee = new MySqlTableCreator( $database_mock, $options );
		$testee->create_table( $schema_mock );
	}

	/**
	 * @see test_create_table
	 * @return array
	 */
	public function create_table_data() {

		return [
			'single_column' => [
				[
					'name' => 'wp_posts',
					'schema' => [
						'id' => [
							'name' => 'id',
							'definition' => 'BIGINT NOT NULL AUTO_INCREMENT',
						],
					],
					'primary_key' => [],
					'indices' => [],
				],
				0,
				"CREATE TABLE `wp_posts` ( `id` BIGINT NOT NULL AUTO_INCREMENT );",
			],
			'single_column_temporary' => [
				[
					'name' => 'wp_posts',
					'schema' => [
						'id' => [
							'name' => 'id',
							'definition' => 'BIGINT NOT NULL AUTO_INCREMENT',
						],
					],
					'primary_key' => [],
					'indices' => [],
				],
				MySqlTableCreator::TEMPORARY,
				"CREATE TEMPORARY TABLE `wp_posts` ( `id` BIGINT NOT NULL AUTO_INCREMENT );",
			],
			'single_column_if_not_exists' => [
				[
					'name' => 'wp_posts',
					'schema' => [
						'id' => [
							'name' => 'id',
							'definition' => 'BIGINT NOT NULL AUTO_INCREMENT',
						],
					],
					'primary_key' => [],
					'indices' => [],
				],
				MySqlTableCreator::IF_NOT_EXISTS,
				"CREATE TABLE IF NOT EXISTS `wp_posts` ( `id` BIGINT NOT NULL AUTO_INCREMENT );",
			],
			'single_column_temporary_if_not_exists' => [
				[
					'name' => 'wp_posts',
					'schema' => [
						'id' => [
							'name' => 'id',
							'definition' => 'BIGINT NOT NULL AUTO_INCREMENT',
						],
					],
					'primary_key' => [],
					'indices' => [],
				],
				MySqlTableCreator::TEMPORARY | MySqlTableCreator::IF_NOT_EXISTS,
				"CREATE TEMPORARY TABLE IF NOT EXISTS `wp_posts` ( `id` BIGINT NOT NULL AUTO_INCREMENT );",
			],
			'three_columns_primary_key' => [
				[
					'name' => 'wp_posts',
					'schema' => [
						'id' => [
							'name' => 'id',
							'definition' => 'BIGINT NOT NULL AUTO_INCREMENT',
						],
						'title' => [
							'name' => 'title',
							'definition' => 'VARCHAR(255)',
						],
						'text' => [
							'name' => 'text',
							'definition' => 'TEXT',
						],
					],
					'primary_key' => [ 'id' ],
					'indices' => [],
				],
				0,
				"CREATE TABLE `wp_posts` ( `id` BIGINT NOT NULL AUTO_INCREMENT,"
				. " `title` VARCHAR(255),"
				. " `text` TEXT ,"
				. " PRIMARY KEY (`id`)"
				. " );",
			],
			'three_columns_primary_key_combined' => [
				[
					'name' => 'wp_posts',
					'schema' => [
						'id_key' => [
							'name' => 'id_column_name',
							'definition' => 'BIGINT NOT NULL AUTO_INCREMENT',
						],
						'title_key' => [
							'name' => 'title_column_name',
							'definition' => 'VARCHAR(255)',
						],
						'text' => [
							'name' => 'text',
							'definition' => 'TEXT',
						],
					],
					'primary_key' => [ 'id_key', 'title_key' ],
					'indices' => [],
				],
				0,
				"CREATE TABLE `wp_posts` ( `id_column_name` BIGINT NOT NULL AUTO_INCREMENT,"
				. " `title_column_name` VARCHAR(255),"
				. " `text` TEXT ,"
				. " PRIMARY KEY (`id_column_name`,`title_column_name`)"
				. " );",
			],
			'three_columns_primary_key_single_index' => [
				[
					'name' => 'wp_posts',
					'schema' => [
						'id_key' => [
							'name' => 'id_column_name',
							'definition' => 'BIGINT NOT NULL AUTO_INCREMENT',
						],
						'title_key' => [
							'name' => 'title_column_name',
							'definition' => 'VARCHAR(255)',
						],
						'text' => [
							'name' => 'text',
							'definition' => 'TEXT',
						],
					],
					'primary_key' => [ 'id_key' ],
					'indices' => [
						'id_title' => [
							'name' => 'id_title_key_name',
							'definition' => 'KEY %% (%id_key%, %title_key%)'
						]
					],
				],
				0,
				"CREATE TABLE `wp_posts` ( `id_column_name` BIGINT NOT NULL AUTO_INCREMENT,"
				. " `title_column_name` VARCHAR(255),"
				. " `text` TEXT"
				. " , PRIMARY KEY (`id_column_name`)"
				. " , KEY `id_title_key_name` (`id_column_name`, `title_column_name`)"
				. " );",
			],
			'three_columns_primary_key_single_index' => [
				[
					'name' => 'wp_posts',
					'schema' => [
						'id_key' => [
							'name' => 'id_column_name',
							'definition' => 'BIGINT NOT NULL AUTO_INCREMENT',
						],
						'title_key' => [
							'name' => 'title_column_name',
							'definition' => 'VARCHAR(255)',
						],
						'slug' => [
							'name' => 'slug',
							'definition' => 'VARCHAR(255) NOT NULL',
						],
					],
					'primary_key' => [ 'id_key' ],
					'indices' => [
						'id_title' => [
							'name' => 'id_title_key_name',
							'definition' => 'KEY %% (%id_key%, %title_key%)'
						],
						'slug_unique' => [
							'name' => 'slug',
							'definition' => 'UNIQUE %% (%slug%)'
						]
					],
				],
				0,
				"CREATE TABLE `wp_posts` ( `id_column_name` BIGINT NOT NULL AUTO_INCREMENT,"
				. " `title_column_name` VARCHAR(255),"
				. " `slug` VARCHAR(255) NOT NULL"
				. " , PRIMARY KEY (`id_column_name`)"
				. " , KEY `id_title_key_name` (`id_column_name`, `title_column_name`), UNIQUE `slug` (`slug`)"
				. " );",
			],
		];
	}

	private function build_table_schema( array $table_data ) {

		$schema_mock = Mockery::mock( TableSchema::class );

		$schema_mock->shouldReceive( 'name' )
			->andReturn( $table_data[ 'name' ] );

		$schema_mock->shouldReceive( 'schema' )
			->andReturn( $table_data[ 'schema' ] );

		$schema_mock->shouldReceive( 'primary_key' )
			->andReturn( $table_data[ 'primary_key' ] );

		$schema_mock->shouldReceive( 'indices' )
			->andReturn( $table_data[ 'indices' ] );

		return $schema_mock;
	}
}
