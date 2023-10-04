<?php
/**
 * Register blocks functionality
 *
 * @package           wis-test-theme
 */

namespace WISTestTheme\Handlers\Blocks;

defined( 'ABSPATH' ) || exit;

use WISTestTheme\Config;
use WISBlocks;

class Register
{

    /**
     * Register all blocks in blocks directory
     *
     * @return void
     */
    public static function registerBlocks(): void
    {
        if ( ! function_exists( 'register_block_type_from_metadata' ) ) {
            return;
        }

        $blocks = glob( Config::get( 'blocksDir' ) . '*', GLOB_ONLYDIR );

        foreach ( $blocks as $blockPath ) {
            $blockName = basename( $blockPath );

            $blockMetaPath = $blockPath . '/block.json';

            $blockClass = 'WISBlocks\\' . $blockName . '\\BlockRenderer';

            if ( ! file_exists( $blockMetaPath ) ) {
                continue;
            }

            self::registerBlockTypeFromMetadata( $blockMetaPath, $blockClass );

            self::registerBlocksRestApiEndpoints( $blockClass );

            self::registerBlockOnInitFunctions( $blockClass );
        }
    }

    /**
     * Add Gutenberg block category
     *
     * @param  array  $categories
     *
     * @return array
     * @see https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#managing-block-categories
     */
    public static function registerBlocksCategories( array $categories ): array
    {
        return array_merge( [
            [
                'slug'  => Config::get( 'blocksCategory' ),
                'title' => 'WIS Blocks',
            ],
        ], $categories );
    }

    /**
     * Register block type from block.json metadata file
     * And register callback from block folder controller php file if exists
     *
     * @param  string  $blockMetaPath
     * @param  string  $blockClass
     *
     * @return void
     */
    public static function registerBlockTypeFromMetadata( string $blockMetaPath, string $blockClass ): void
    {
        $blockTypeArgs = [];

        if ( method_exists( $blockClass, 'blockServerSideCallback' ) ) {
            $blockTypeArgs['render_callback'] = function ( $attributes, $content, $block ) use ( $blockClass ) {
                return call_user_func( [
                    $blockClass,
                    'blockServerSideCallback',
                ], $attributes, $content, $block );
            };
        }

        register_block_type_from_metadata( $blockMetaPath, $blockTypeArgs );
    }

    /**
     * If we are calling registerBlocks() function on init hook,
     * we can call blockOnInit() function from block folder controller php file if exists
     *
     * @param $blockClass
     *
     * @return void
     */
    public static function registerBlockOnInitFunctions( $blockClass ): void
    {
        if ( method_exists( $blockClass, 'blockOnInit' ) ) {
            call_user_func( [
                $blockClass,
                'blockOnInit',
            ] );
        }
    }

    /**
     * Register rest api callback from block folder controller php file if exists
     *
     * @param  string  $blockClass
     *
     * @return void
     */
    public static function registerBlocksRestApiEndpoints( string $blockClass ): void
    {
        if ( ! method_exists( $blockClass, 'blockRestApiEndpoints' ) ) {
            return;
        }

        add_action( 'rest_api_init', function () use ( $blockClass ) {
            call_user_func( [
                $blockClass,
                'blockRestApiEndpoints',
            ] );
        } );
    }


}
