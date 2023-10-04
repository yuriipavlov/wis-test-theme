<?php
/**
 * Blocks interface for blocks controllers
 *
 * @package           wis-test-theme
 */

namespace WISTestTheme\Handlers\Blocks;

defined( 'ABSPATH' ) || exit;

interface BlockInterface
{
    /**
     * Block server side endpoint
     *
     * @param $attributes
     * @param $content
     * @param $block
     *
     * @return string
     */
    public static function blockServerSideCallback( $attributes, $content, $block ): string;

}
