<?php

/**
 * Hooks functionality for the theme.
 *
 * Run hook handlers
 */

namespace WISTestTheme\Base;

defined('ABSPATH') || exit;

use WISTestTheme\Handlers;

class Hooks
{
    public static function initHooks(): void
    {
        /************************************
         *           Setup Theme
         ************************************/
        add_action('after_setup_theme', [Handlers\SetupTheme::class, 'registerMenus']);


        /************************************
         *         Gutenberg blocks
         ************************************/
        add_action('block_categories_all', [Handlers\Blocks\Register::class, 'registerBlocksCategories']);
        add_action('init', [Handlers\Blocks\Register::class, 'registerBlocks']);


        /************************************
         *          Theme Settings
         ************************************/
        add_action('after_setup_theme', [Handlers\Settings\ThemeSettings::class, 'boot']);
        add_action('carbon_fields_register_fields', [Handlers\Settings\ThemeSettings::class, 'make']);


        /************************************
         *            Front
         ************************************/
        add_action('wp_enqueue_scripts', [Handlers\Front::class, 'enqueueThemeAssets']);
        add_action('wp_enqueue_scripts', [Handlers\Front::class, 'loadFrontendJsData']);

        add_action('enqueue_block_editor_assets', [Handlers\Front::class, 'enqueueBlockEditorAssets']);

        add_action('wp_head', [Handlers\Front::class, 'addGTMHead']);
        add_action('wp_footer', [Handlers\Front::class, 'addGTMBody']);

        add_action('style_loader_src', [Handlers\Front::class, 'addFileTimeToStyles'], 10, 2);


        /************************************
         *       Security and CleanUp
         ************************************/
        add_action('init', [Handlers\Security\Xmlrpc::class, 'disableXmlrpcTrackbacks']);
        add_action('init', [Handlers\Security\CleanUp::class, 'headCleanup'], 999);
        add_action('init', [Handlers\Security\Optimization::class, 'init']);
        add_action('init', [Handlers\Security\Comments::class, 'disableComments']);

    }
}
