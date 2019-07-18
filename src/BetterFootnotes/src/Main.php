<?php
/**
 * Main class file.
 * 
 * @package BetterFootnotes
 * @since   1.0
 */
namespace BetterFootnotes;

/**
 * Main class.
 * 
 * @since 1.0
 */
class Main
{
    /**
     * Private constructor.
     * 
     * @access private
     * @since  1.0
     */
    private function __construct()
    {
    }

    /**
     * Setup plugin's hooks.
     * 
     * @return void
     * @since  1.0
     */
    public function setupHooks()
    {
        add_action('init', [$this, 'loadLocale'], 1);
        add_action('init', [$this, 'registerShortcodes']);
        add_action('wp_enqueue_scripts', [$this, 'registerScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * Load plugin translations.
     * 
     * @return void
     * @since  1.0
     */
    public function loadLocale()
    {
        load_plugin_textdomain('better-footnotes', false, basename(PLUGIN_PATH) . '/locales');
    }

    /**
     * Register plugin shortcodes.
     * 
     * @return void
     * @since  1.0
     */
    public function registerShortcodes()
    {
        add_shortcode('footnote', [$this, 'shortcodeFootnote']);
        add_shortcode('footnotes', [$this, 'shortcodeFootnotes']);
    }

    /**
     * Register plugin scripts and styles.
     * 
     * @return void
     * @since  1.0
     */
    public function registerScripts()
    {
        if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
            wp_register_style('better-footnotes', PLUGIN_URL . 'assets/css/better-footnotes.css', [], PLUGIN_VERSION);
            wp_register_script('better-footnotes', PLUGIN_URL . 'assets/js/better-footnotes.js', ['jquery'], PLUGIN_VERSION, true);
        } else {
            wp_register_style('better-footnotes', PLUGIN_URL . 'assets/css/better-footnotes.min.css', [], PLUGIN_VERSION);
            wp_register_script('better-footnotes', PLUGIN_URL . 'assets/js/better-footnotes.min.js', ['jquery'], PLUGIN_VERSION, true);
        }
    }

    /**
     * Enqueue plugin scripts and styles.
     * 
     * @return void
     * @since  1.0
     */
    public function enqueueScripts()
    {
        if (! is_single()) {
            return;
        }

        wp_enqueue_style('better-footnotes');

        wp_enqueue_script('better-footnotes');
        wp_localize_script('better-footnotes', 'betterFootnotesOptions', [
            'scrollGap'   => Options::getOption('scroll_gap'),
            'scrollSpeed' => Options::getOption('scroll_speed'),
        ]);
    }

    /**
     * Shortcode 'footnote' callback.
     * 
     * @return string
     * @since  1.0
     */
    public function shortcodeFootnote($atts, $content)
    {
        $output = '';
        $post = get_post();

        $atts = shortcode_atts([
            'type' => 'numeric',
        ], $atts);

        switch ($atts['type']) {
            case "numeric":
                $footnoteNum = Registry::addOrderedFootnote($content);
                $footnoteId = 'article-footnote-' . $post->ID . '-' . $footnoteNum;
                $footnoteHookId = 'article-footnote-hook-' . $post->ID . '-' . $footnoteNum;
                $output = '<a class="bfn-footnoteHook" id="' . $footnoteHookId . '" href="#' . $footnoteId . '">' . $footnoteNum . '</a>';
                break;
            default:
            case "numberless":
            case "non-numeric":
                $footnoteNum = Registry::addUnorderedFootnote($content);
                $footnoteId = 'article-footnote-numberless-' . $post->ID . '-' . $footnoteNum;
                $footnoteHookId = 'article-footnote-numberless-hook-' . $post->ID . '-' . $footnoteNum;
                $output = '<a class="bfn-footnoteHook" id="' . $footnoteHookId . '" href="#' . $footnoteId . '">' . Options::getOption('footnote_symbol') . '</a>';
                break;
        }

        return $output;
    }

    /**
     * Shortcode 'footnotes' callback.
     * 
     * @return string
     * @since  1.0
     */
    public function shortcodeFootnotes($atts)
    {
        $output = '';

        if (Registry::isEmpty()) {
            return $output;
        }

        $post = get_post();

        $atts = shortcode_atts([
            'title'     => __('References', 'better-footnotes'),
            'title_tag' => 'h3',
        ], $atts);

        if (empty($atts['title_tag'])) {
            $atts['title_tag'] = 'h3';
        }

        $output = '<div class="bfn-footnotes">';

        if (! empty($atts['title'])) {
            $output .= "<{$atts['title_tag']} class='bfn-footnotes-title'>" . $atts['title'] . "</{$atts['title_tag']}>";
        }

        $output .= '<ul class="bfn-footnotesList">';

        if (Registry::hasUnorderedFootnotes()) {
            foreach (Registry::getUnorderedFootnotes() as $nth => $footnote) {
                $footnoteId = 'article-footnote-numberless-' . $post->ID . '-' . ($nth + 1);
                $footnoteHookId = 'article-footnote-numberless-hook-' . $post->ID . '-' . ($nth + 1);

                $output .= '<li class="bfn-footnoteItem">';
                $output .= '<a class="bfn-footnoteRef" id="' . esc_attr($footnoteId) . '" href="#' . esc_attr($footnoteHookId) . '">';
                $output .= esc_html(Options::getOption('footnote_symbol'));
                $output .= '</a> ';
                $output .= $footnote;
                $output .= '</li>';
            }
        }

        if (Registry::hasOrderedFootnotes()) {
            foreach (Registry::getOrderedFootnotes() as $nth => $footnote) {
                $footnoteId = 'article-footnote-' . $post->ID . '-' . ($nth + 1);
                $footnoteHookId = 'article-footnote-hook-' . $post->ID . '-' . ($nth + 1);

                $output .= '<li class="bfn-footnoteItem">';
                $output .= '<a class="bfn-footnoteRef" id="' . esc_attr($footnoteId) . '" href="#' . esc_attr($footnoteHookId) . '">';
                $output .= ($nth + 1);
                $output .= '</a> ';
                $output .= $footnote;
                $output .= '</li>';
            }
        }

        $output .= '</ul>';
        $output .= '</div>';

        Registry::reset();

        return $output;
    }

    /*** Singleton ************************************************************/

    /**
     * Create plugin's main instance once.
     * 
     * @return void
     * @since  1.0
     * @static
     */
    public static function instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self;
            $instance->setupHooks();
        }

        return $instance;
    }
}
