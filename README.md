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

// copy table structure
$copier->copy_structure( 'wp_options', 'wp_options_copy' );

// copy table and content
$copier->copy( 'wp_posts', 'wp_posts_copy' );
```