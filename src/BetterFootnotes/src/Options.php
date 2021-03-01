<?php
/**
 * Options class file.
 * 
 * @package BetterFootnotes
 * @since   1.0
 */
namespace BetterFootnotes;

/**
 * Options class.
 * 
 * @since 1.0
 */
class Options
{
    /**
     * Get plugin's options.
     * 
     * @return array
     * @since  1.0
     * @static
     */
    public static function getOptions()
    {
        $defaults = [
            'footnote_symbol' => '&sect;',
            'auto_append'     => 'n',
            'scroll_gap'      => 0,
            'scroll_speed'    => 350,
            'group_footnotes' => 0,
        ];

        $options = get_option('bfn_opts', $defaults);
        return $options;
    }

    /**
     * Get plugin's option.
     * 
     * @return mixed
     * @since  1.0
     * @static
     */
    public static function getOption($optionName)
    {
        $optionValue = null;
        $optionName = (string) $optionName;

        if (empty($optionName)) {
            return $optionValue;
        }

        $options = self::getOptions();
        if (isset($options[$optionName])) {
            $optionValue = $options[$optionName];
        }

        return $optionValue;
    }

    /**
     * Update plugin's options.
     * 
     * @return bool
     * @since  1.0
     * @static
     */
    public static function updateOptions(array $options)
    {
        return update_option('bfn_opts', $options);
    }
}
