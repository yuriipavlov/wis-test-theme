<?php
/**
 * Application main class
 *
 * @package           wis-test-theme
 */

namespace WISTestTheme;

use WISTestTheme\Base\Hooks;

defined( 'ABSPATH' ) || exit;

final class WISTestTheme
{

    public function __construct()
    {
    }

    /**
     * Run the plugin
     */
    public function run(): void
    {
        // Main Hooks functionality for the plugin
        Hooks::initHooks();

    }

}
