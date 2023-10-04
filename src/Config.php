<?php
/**
 * Theme configuration handler
 *
 * @package           wis-test-theme
 */

namespace WISTestTheme;

defined( 'ABSPATH' ) || exit;

class Config
{
    /**
     * Application main configuration
     *
     * @return array
     */
    private static function main(): array
    {
        return [
            'version'           => '0.0.1',
            'settingsPrefix'    => 'wist_',
            'restApiNamespace'  => 'wist/v1',
            'assetsUri'         => '/assets/',
            'blocksDir'         => get_template_directory() . '/blocks/',
            'blocksCategory'    => 'wis-test-theme',
            'blocksViewDir'     => 'view/',
        ];
    }

    /**
     * Optimization configuration
     *
     * @return array
     */
    private static function optimization(): array
    {
        return [
            'cleanWpHead'               => true,
            'removeBlocksDefaultStyles' => false,
            'cleanBodyClass'            => true,
            'removeAssetsAttributes'    => true,
            'disableComments'           => true,
            'addNoCacheHeaders'         => true,
        ];
    }

    /**
     * Get config value by key
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public static function get( string $key ): mixed
    {
        $config = self::getConfig();

        return $config[ $key ] ?? '';
    }

    /**
     * Get all config
     *
     * @return array
     */
    public static function getConfig(): array
    {
        $config = array_merge(
            self::main(),
            self::optimization(),
        );

        return apply_filters( 'wist_theme/config', $config );
    }

}
