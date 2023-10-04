<?php
/**
 * Plugin settings handler
 *
 * @package           wis-test-theme
 */

namespace WISTestTheme\Handlers\Settings;

defined( 'ABSPATH' ) || exit;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use WISTestTheme\Config;

class ThemeSettings
{
    /**
     * Connect Carbon Fields
     *
     * @return void
     */
    public static function boot(): void
    {
        Carbon_Fields::boot();
    }

    /**
     * Make Carbon Fields
     *
     * @return void
     */
    public static function make(): void
    {
        $prefix = Config::get( 'settingsPrefix' );

        $container = Container::make(
            'theme_options',  // type
            'theme_settings', // id
            __( 'Site Settings', 'wis-test-theme' ) // desc
        );

        $container->set_page_parent( 'options-general.php' ); // id of the "Appearance" admin section
        $container->set_page_menu_title( 'Site Settings' );
        $container->set_icon( 'dashicons-carrot' );


        /** General */
        $container->add_tab( __( 'General', 'wis-test-theme' ),
            [
                Field::make( 'separator', $prefix . 'sep_general_identity', __( 'Identity', 'wis-test-theme' ) ),
                Field::make( 'image', $prefix . 'favicon_image', __( 'Favicon Image', 'wis-test-theme' ) ),
            ]
        );

        /** Analytics */
        $container->add_tab( __( 'Analytics', 'wis-test-theme' ),
            [
                Field::make( 'separator', $prefix . 'sep_analytics_google', __( 'Google', 'wis-test-theme' ) ),

                Field::make( 'text', $prefix . 'tag_manager_code', __( 'Tag Manager Code', 'wis-test-theme' ) )
                     ->set_attribute( 'placeholder', 'GTM-XXXXXXX' )
                     ->set_width( 50 ),

                Field::make( 'text', $prefix . 'analytics_code', __( 'Analytics Code', 'wis-test-theme' ) )
                     ->set_attribute( 'placeholder', 'UA-XXXXXXXXX-X' )
                     ->set_help_text( __( 'For a better speed performance, please insert the analytics code through the tag manager. Turn on google Analytics Scripts Local Load option',
                         'wis-test-theme' ) )
                     ->set_width( 50 ),
                /*
                Field::make( 'checkbox', $prefix . 'analytics_js_lazy_load', __( 'Analytics Scripts Local Load', 'wis-test-theme' ) )
                     ->set_option_value( '1' )
                     ->set_default_value( '' )
                     ->set_help_text( __( 'Load Tag Manager and Analytics scripts from local directory', 'wis-test-theme' ) ),
                */
            ]
        );
    }

}
