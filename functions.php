<?php
/**
 * WIS Test Theme
 *
 * @package           wis-test-theme
 * @author            Yurii Pavlov
 * @link
 * @license
 */

use WISTestTheme\WISTestTheme;

defined( 'ABSPATH' ) || exit;

if ( PHP_VERSION_ID < 80100 ) {
    error_log( sprintf( __( 'Theme require at least PHP 8.1.0 ( You are using PHP %s ) ' ), PHP_VERSION ) );

    return;
}

try {
    require_once __DIR__ . '/vendor/autoload.php';

    $WISTestTheme = new WISTestTheme();

    $WISTestTheme->run();

} catch ( Throwable $throwable ) {
    $error_message = 'PHP error: ' . $throwable->getMessage() . ' in ' . $throwable->getFile() . ' on line ' . $throwable->getLine();
    $error_message .= PHP_EOL . 'Stack trace:';
    $error_message .= PHP_EOL . $throwable->getTraceAsString();

    error_log( $error_message );
}
