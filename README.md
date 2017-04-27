# WP DB tools

API for manging ()_creating_, _deleting_, _copying_) MySQL tables. Providing adapter 
for `wpdb` (and planed also for`PDO`).

**Work in progress!** You should only use discrete releases (0.1.0,…) and follow the CHANGELOG.md. Braking changes are likely within pre-release versions (0.2.0, 0.3.0,…). Use the tilde operator in your composer version constraint: `~0.1.0` to fetch only releases on «bug fix» level.

## Install

```
compser require inpsyde/wp-db-tools:~0.1.0
```

## Usage examples

### YAML table schema

Create a file `my_table.yml` and specify the table schema like so:

```yaml
table:
  name: my_table
  # Prefix is optional but if specified only the two values
  # 'network' and 'site' are allowed
  prefix: network
  schema:
    id:
      name: id
      description: BIGINT NOT NULL
    title:
      name: title
      description: VARCHAR(255)
  primary_key:
    - id
  indices:
    my_index:
      name: my_index
      description: UNIQUE my_index (title)
```

This will result in the following SQL statement:

```SQL
CREATE TABLE `wp_my_table` (
    `id` BIGINT NOT NULL,
    `title` VARCHAR(255),
    PRIMARY KEY (`id_column`),
    UNIQUE my_index (title)
)
```

The API will quote identifiers with with grave accents (backticks <code>&#96;</code> U+0060) where they are distinct to identify. This will fit most use cases. However, if you want to use characters in your identifiers (index names and definitions) that [needs quotation](https://dev.mysql.com/doc/refman/5.7/en/identifiers.html) you can use placeholders that references the internal keys of columns/indices:

```yaml
table:
  name: merkel_table-<>-
  schema:
    id:
      name: "id (hopefully_unique*lol*)"
      description: BIGINT NOT NULL
    title:
      name: "title (super_important_for_SEO!!!)"
      description: VARCHAR(255)
  primary_key:
    - id
  indices:
    my_index:
      name: "my_index (note to dev-ops: this will scale much better)"
      description: "UNIQUE %% (%title%)"
```

will result in the SQL statement:

```SQL
CREATE TABLE `merkel_table-<>-` (
    `id (hopefully_unique*lol*)` BIGINT NOT NULL,
    `title (super_important_for_SEO!!!)` VARCHAR(255),
    PRIMARY KEY (`id (hopefully_unique*lol*)`),
    UNIQUE `my_index_(note to dev-ops: this will scale much better)` (`title (super_important_for_SEO!!!)`)
)
```

Primary Keys always have to reference the associative key of each column in the schema (in that example `id` instead of the actual name).

In indices description the following placeholders are allowed:

 * `%%` will be replaced with the quoted index name
 * `%<column_key>%` will be replaced with the quoted name of the referenced column in the schema

### Create table API

```php

use WpDbTools\Action\MySqlTableCreator;
use WpDbTools\Db\WpDbAdapter;
use WpDbTools\Factory\TableSchemaFactory;

$table_creator = new MySqlTableCreator( WpDbAdapter::from_globals() );
$schema_factory = TableSchemaFactory::from_globals();
$table_schema = $schema_factory->create_from_yaml_file( 'config/my_table.yml' );

$table_creator->create_table( $table_schema );
```

#### Temporary / if-not-exists flags

If you want the SQL statment to include `TEMPORARY` or `IF NOT EXISTS` options, you can pass them bitwise to the constructor of `MySqlTableCreator`:

```php

use WpDbTools\Action\MySqlTableCreator;
use WpDbTools\Db\WpDbAdapter;

$table_creator = new MySqlTableCreator(
    WpDbAdapter::from_globals(),
    MySqlTableCreator::TEMPORARY | MySqlTableCreator::IF_NOT_EXISTS
);
```

This will result in the SQL statement:

```sql
CREATE TEMPORARY TABLE IF NOT EXISTS `my_table` …
```

### Copy a table

```php

use WpDbTools\Action\MySqlTableCopier;
use WpDbTools\Action\MySqlTableLookup;
use WpDbTools\Db\WpDbAdapter;

$adapter = new WpDbAdapter( $GLOBALS[ 'wpdb' ] );
$copier = new MySqlTableCopier( $adapter );
$lookup = new MySqlTableLookup( $adapter );

// copy table structure
if ( ! $lookup->table_exists( 'wp_options_copy' ) )
	$copier->copy_structure( 'wp_options', 'wp_options_copy' );

// copy table and content
if ( ! $lookup->table_exists( 'wp_posts_copy' ) )
	$copier->copy( 'wp_posts', 'wp_posts_copy' );
```

## Roadmap

 * Specify a bit-mask schema to unify options like `ARRAY_A` independent for the used DB adapter
 * API to identify and handle schema updates (schema-delta)
 * Translate WP style prepared statements syntax in PDO prepared statment syntax and vice versa

## Run tests

Install phpunit locally via [phive](https://phar.io/):

```
$ phive install
```

Alternatively install phpunit version `^5.7` (`^6.0` is only supported by the unit tests right now, not by the WordPress system tests).

Run unit tests:

```
$ tests/bin/phpunit
```

Prepare WordPress system tests: Copy `phpunit-system.xml.dist` to `phpunit-system.xml` and insert your DB credentials. Then run

```
$ tests/bin/phpunit -c phpunit-system.xml
```
