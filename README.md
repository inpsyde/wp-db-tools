# WP DB tools

Solving repetitive tasks like _creating_, _deleting_, _copying_ and _altering: MySQL tables. Providing adapter 
for `wpdb` as well as `PDO`.

Work in progress!

## Usage examples

### Copy a table

```php

use
	WpDbTools\Action,
	WpDbTools\Db;

$adapter = new Db\WpDbAdapter( $GLOBALS[ 'wpdb' ] );
$copier = new Action\MySqlTableCopier( $adapter );
$lookup = new Action\MySqlTableLookup( $adapter );

// copy table structure
if ( ! $lookup->table_exists( 'wp_options_copy' ) )
	$copier->copy_structure( 'wp_options', 'wp_options_copy' );

// copy table and content
if ( ! $lookup->table_exists( 'wp_posts_copy' ) )
	$copier->copy( 'wp_posts', 'wp_posts_copy' );
```