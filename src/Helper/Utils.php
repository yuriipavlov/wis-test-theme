<?php
/**
 * Utilities
 *
 * Helper functions
 *
 * @package           wis-test-theme
 */

namespace WISTestTheme\Helper;

use WISTestTheme\Config;

defined( 'ABSPATH' ) || exit;

class Utils
{
    /**
     * Get Site Option
     *
     * @param  string      $optionName
     * @param  mixed|null  $defaultValue
     *
     * @return mixed
     */
    public static function getOption( string $optionName, mixed $defaultValue = null ): mixed
    {
        $prefix = Config::get( 'settingsPrefix' );
        $prefix = "_{$prefix}";
        $value  = \get_option( $prefix . $optionName, $defaultValue );

        return $value ?? $defaultValue;
    }


    /**
     * Get Site Option with framework functionality
     * for specific cases, reduce performance
     *
     * @param  string      $optionName
     * @param  mixed|null  $defaultValue
     *
     * @return mixed
     */
    public static function getOptionFw( string $optionName, mixed $defaultValue = null ): mixed
    {
        $prefix = Config::get( 'settingsPrefix' );
        $value  = \carbon_get_theme_option( $prefix . $optionName );

        return $value ?? $defaultValue;
    }

    /**
     * Set Theme Option
     *
     * @param  string     $optionName
     * @param  mixed      $value
     * @param  bool|null  $autoload
     */
    public static function setOption( string $optionName, mixed $value, bool $autoload = null ): void
    {
        $optionName = self::addPrefix( $optionName );
        \update_option( $optionName, $value, $autoload );
    }

    /**
     * Get Network Site Option
     *
     * @param  int     $siteId
     * @param  string  $optionName
     * @param  mixed   $defaultValue
     *
     * @return mixed
     */
    public static function getNetworkOption( int $siteId, string $optionName, mixed $defaultValue = null ): mixed
    {
        $prefix = Config::get( 'settingsPrefix' );
        $prefix = "_{$prefix}";
        $value  = \get_network_option( $siteId, $prefix . $optionName, $defaultValue );

        return $value ?? $defaultValue;
    }


    /**
     * Get Network Site Option with framework functionality
     * for specific cases, reduce performance
     *
     * @param  int         $siteId
     * @param  string      $optionName
     * @param  mixed|null  $defaultValue
     *
     * @return mixed
     */
    public static function getNetworkOptionFw( int $siteId, string $optionName, mixed $defaultValue = null ): mixed
    {
        $prefix = Config::get( 'settingsPrefix' );
        $value  = \carbon_get_network_option( $siteId, $prefix . $optionName );

        return $value ?? $defaultValue;
    }


    /**
     * Get Post Meta with framework functionality
     *
     * @param  int         $postId
     * @param  string      $metaKey
     * @param  mixed|null  $default
     * @param  bool        $usePrefix
     *
     * @return mixed
     */
    public static function getPostMeta( int $postId, string $metaKey, mixed $default = null, bool $usePrefix = true ): mixed
    {
        $metaKey = $usePrefix ? self::addPrefix( $metaKey ) : $metaKey;
        $value   = \carbon_get_post_meta( $postId, $metaKey );

        return in_array( $value, [
            '',
            false,
            null,
            [],
        ], true ) ? $default : $value;
    }


    /**
     * Get Term Meta
     *
     * @param  int     $termId
     * @param  string  $metaKey
     * @param  mixed   $default
     * @param  bool    $usePrefix
     *
     * @return mixed
     */
    public static function getTermMeta( int $termId, string $metaKey, mixed $default = null, bool $usePrefix = true ): mixed
    {
        $metaKey = $usePrefix ? self::addPrefix( $metaKey ) : $metaKey;
        $value   = \carbon_get_term_meta( $termId, $metaKey );

        return in_array( $value, [
            '',
            false,
            null,
            [],
        ], true ) ? $default : $value;
    }


    /**
     * @param  string  $name
     *
     * @return string
     */
    public static function addPrefix( string $name ): string
    {
        $prefix = Config::get( 'settingsPrefix' );

        if ( ! $prefix ) {
            return $name;
        }

        return self::isPrefixed( $name, $prefix ) ? $name : $prefix . $name;
    }


    /**
     * Check if string is prefixed
     *
     * @param  string  $name
     * @param  string  $prefix
     *
     * @return string
     */
    public static function isPrefixed( string $name, string $prefix ): string
    {
        return str_starts_with( $name, $prefix );
    }


    /**
     * Error Handler function
     *
     * @param $throwable
     *
     * @return void
     */
    public static function errorHandler( $throwable ): void
    {
        $error_message = 'PHP error: ' . $throwable->getMessage() . ' in ' . $throwable->getFile() . ' on line ' . $throwable->getLine();
        $error_message .= PHP_EOL . 'Stack trace:';
        $error_message .= PHP_EOL . $throwable->getTraceAsString();

        error_log( $error_message );
    }

}
