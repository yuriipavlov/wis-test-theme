<?php
/**
 * Front handler
 *
 * @package           wis-test-theme
 */

namespace WISTestTheme\Handlers;

use WISTestTheme\Config;
use WISTestTheme\Helper\Utils;

defined('ABSPATH') || exit;

class Front
{
    public static function enqueueThemeAssets(): void
    {
        $style = '/assets/build/styles/theme.css';

        $styleUri  = get_template_directory_uri() . $style;
        $stylePath = get_template_directory() . $style;

        wp_enqueue_style('wis-test-theme-style', $styleUri, [], filemtime($stylePath));
    }

    public static function enqueueBlockEditorAssets(): void
    {
        $style = '/assets/build/styles/editor.css';

        $styleUri  = get_template_directory_uri() . $style;
        $stylePath = get_template_directory() . $style;

        wp_enqueue_style('wis-test-theme-editor-style', $styleUri, [], filemtime($stylePath));
    }


    public static function loadFrontendJsData(): void
    {
        wp_register_script('front-vars', '', [], '', true);
        wp_enqueue_script('front-vars');
        $frontendData = [
            'restApiUrl'    => get_rest_url(),
            'restNamespace' => Config::get('restApiNamespace'),
        ];

        wp_localize_script('front-vars', 'frontendData', $frontendData);
    }


    /**
     * Adding ver=<file-time> to styles src for refresh user side cache
     *
     * @param $src
     * @param $handle
     *
     * @return string
     */
    public static function addFileTimeToStyles($src, $handle): string
    {
        $registered_styles = wp_styles()->registered;

        $style = $registered_styles[$handle] ?? '';

        if (
            empty($style) ||
            ! empty($style->ver) ||
            empty($style->extra['path']) ||
            ! file_exists($style->extra['path'])
        ) {
            return $src;
        }

        return add_query_arg('ver', filemtime($style->extra['path']), $src);
    }

    public static function addGTMHead(): void
    {
        $tag_manager_code = Utils::getOption('tag_manager_code', '');

        if (empty($tag_manager_code)) {
            return;
        }

        ?>
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
                var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '<?php echo $tag_manager_code; ?>');
        </script>
        <?php
    }

    public static function addGTMBody(): void
    {
        $tag_manager_code = Utils::getOption('tag_manager_code', '');

        if (empty($tag_manager_code)) {
            return;
        }

        ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=<?php
            echo $tag_manager_code; ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php
    }

}
