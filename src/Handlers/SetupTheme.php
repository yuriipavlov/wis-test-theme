<?php
/**
 * Theme setup functionality
 *
 * Run hook handlers
 *
 * @package           wis-test-theme
 */

namespace WISTestTheme\Handlers;

defined( 'ABSPATH' ) || exit;

class SetupTheme
{

    /**
     * Register theme menus
     **/
    public static function registerMenus(): void
    {
        register_nav_menus( [
            'header_menu'     => esc_html__( 'Header Menu', 'wis-test-theme' ),
            'bottom_menu' => esc_html__( 'Bottom Menu', 'wis-test-theme' ),
        ] );
    }

}
