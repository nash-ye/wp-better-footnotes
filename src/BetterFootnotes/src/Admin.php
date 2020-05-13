<?php
/**
 * Admin class file.
 * 
 * @package BetterFootnotes
 * @since   1.0
 */
namespace BetterFootnotes;

/**
 * Admin class.
 * 
 * @since 1.0
 */
class Admin
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
     * Setup plugin's admin hooks.
     * 
     * @return void
     * @since  1.0
     */
    public function setupHooks()
    {
        add_action('admin_menu', [$this, 'registerSettingsPage']);
        add_action('admin_init', [$this, 'registerSettingsFields']);
    }

    /**
     * Register plugin's settings page.
     * 
     * @return void
     * @since  1.0
     */
    public function registerSettingsPage()
    {
        add_options_page(
            __('Better Footnotes Options', 'better-footnotes'),
            __('Better Footnotes', 'better-footnotes'),
            'manage_options',
            'better_footnotes',
            [$this, 'settingsPageContent']
        );
    }

    /**
     * Settings page content.
     * 
     * @return void
     * @since  1.0
     */
    public function settingsPageContent()
    {
        if (! current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        } ?>
        <div class="wrap" id="better-footnotes-options">
            <h1><?php _e('Better Footnotes Options', 'better-footnotes') ?></h1>

            <form method="post" action="options.php">
                <?php settings_fields('bfn_opts') ?>
                <?php do_settings_sections('better_footnotes') ?>

                <?php submit_button() ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register settings fields.
     * 
     * @return void
     * @since  1.0
     */
    public function registerSettingsFields()
    {
        register_setting('bfn_opts', 'bfn_opts', [$this, 'validateSettingsField']);

        // Strings
        add_settings_section(
            'bfn_strings',
            __('Strings', 'better-footnotes'),
            [$this, 'renderSettingsSection'],
            'better_footnotes'
        );

        add_settings_field(
            'footnote_symbol',
            __('Footnote Symbol', 'better-footnotes'),
            [$this, 'renderSettingsField'],
            'better_footnotes',
            'bfn_strings',
            [
                'name'      => 'footnote_symbol',
                'label_for' => 'bfn_footnote_symbol',
            ]
        );

        // Scrolling
        add_settings_section(
            'bfn_scrolling',
            __('Scrolling', 'better-footnotes'),
            [$this, 'renderSettingsSection'],
            'better_footnotes'
        );

        add_settings_field(
            'scroll_gap',
            __('Footnotes Scroll Gap', 'better-footnotes'),
            [$this, 'renderSettingsField'],
            'better_footnotes',
            'bfn_scrolling',
            [
                'name'      => 'scroll_gap',
                'label_for' => 'bfn_scroll_gap',
            ]
        );

        add_settings_field(
            'scroll_speed',
            __('Footnotes Scroll Speed', 'better-footnotes'),
            [$this, 'renderSettingsField'],
            'better_footnotes',
            'bfn_scrolling',
            [
                'name'      => 'scroll_speed',
                'label_for' => 'bfn_scroll_speed',
            ]
        );
    }

    /**
     * Settings sections callback.
     * 
     * @return void
     * @since  1.0
     */
    public function renderSettingsSection($args)
    {
    }

    /**
     * Settings fields callback.
     * 
     * @return void
     * @since  1.0
     */
    public function renderSettingsField($args)
    {
        $args = array_merge(
            [
                'name'      => '',
                'label_for' => '',
            ],
            $args
        );

        if ('footnote_symbol' === $args['name']) : ?>
        <input type="text" id="<?php echo esc_attr($args['label_for']) ?>" name="bfn_opts[footnote_symbol]" value="<?php echo esc_attr(Options::getOption('footnote_symbol')) ?>" class="regular-text">
        <br>
        <span class="description"><?php esc_html_e('Symbol used for non-numeric footnotes.', 'better-footnotes') ?></span>

        <?php elseif ('scroll_gap' === $args['name']) : ?>
        <input type="number" id="<?php echo esc_attr($args['label_for']) ?>" name="bfn_opts[scroll_gap]" value="<?php echo esc_attr(Options::getOption('scroll_gap')) ?>" class="regular-text">
        <br>
        <span class="description"><?php esc_html_e('Use this if you have a fixed component on top of the viewport of your site. This can be dynamically set (see documentation).', 'better-footnotes') ?></span>

        <?php elseif ('scroll_speed' === $args['name']) : ?>
        <input type="number" id="<?php echo esc_attr($args['label_for']) ?>" name="bfn_opts[scroll_speed]" value="<?php echo esc_attr(Options::getOption('scroll_speed')) ?>" class="regular-text">
        <br>
        <span class="description"><?php esc_html_e('Adjusts the scroll animation speed when a footnote is clicked. (0 For no animation).', 'better-footnotes') ?></span>
        <?php endif;
    }

    /**
     * Settings fields vaildation callback.
     * 
     * @return void
     * @since  1.0
     */
    public function validateSettingsField($input)
    {
        return $input;
    }
    
    /*** Singleton ************************************************************/

    /**
     * Create plugin's admin instance once.
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
