<?php
/**
 * Footnotes registry file.
 *
 * @package BetterFootnotes
 * @since   1.0
 */
namespace BetterFootnotes;

/**
 * Footnotes registry.
 *
 * @since 1.0
 */
class Registry
{
    /**
     * Ordered footnotes list.
     *
     * @var    array
     * @since  1.0
     * @static
     */
    protected static $orderedFootnotes = [];

    /**
     * Unordered footnotes list.
     *
     * @var    array
     * @since  1.0
     * @static
     */
    protected static $unorderedFootnotes = [];

    /**
     * Check whether the registry is empty or not.
     *
     * @return bool
     * @since  1.0
     * @static
     */
    public static function isEmpty()
    {
        return empty(self::$unorderedFootnotes) && empty(self::$orderedFootnotes);
    }

    /**
     * Whether the unordered footnotes list is empty or not.
     *
     * @return bool
     * @since  1.0
     * @static
     */
    public static function hasUnorderedFootnotes()
    {
        return ! empty(self::$unorderedFootnotes);
    }

    /**
     * Get the unordered footnotes list.
     *
     * @return array
     * @since  1.0
     * @static
     */
    public static function getUnorderedFootnotes()
    {
        return self::$unorderedFootnotes;
    }

    /**
     * Add a new unordered footnote.
     *
     * @param  string $footnoteContent Footnote content.
     * @return int Unordered footnotes count
     * @since  1.0
     * @static
     */
    public static function addUnorderedFootnote($footnoteContent)
    {
        $footnoteContent = (string) $footnoteContent;
        $footnotesCount = array_push(self::$unorderedFootnotes, $footnoteContent);
        return $footnotesCount;
    }

    /**
     * Whether the ordered footnotes list is empty or not.
     *
     * @return bool
     * @since  1.0
     * @static
     */
    public static function hasOrderedFootnotes()
    {
        return ! empty(self::$orderedFootnotes);
    }

    /**
     * Get the ordered footnotes list.
     *
     * @return array
     * @since  1.0
     * @static
     */
    public static function getOrderedFootnotes()
    {
        return self::$orderedFootnotes;
    }

    /**
     * Add a new ordered footnote.
     *
     * @param  string $footnoteContent Footnote content.
     * @return int Ordered footnotes count.
     * @since  1.0
     * @static
     */
    public static function addOrderedFootnote($footnoteContent)
    {
        $footnoteContent = (string) $footnoteContent;
        $footnotesCount = array_push(self::$orderedFootnotes, $footnoteContent);
        return $footnotesCount;
    }

    /**
     * Reset the registry.
     *
     * @return void
     * @since  1.0
     * @static
     */
    public static function reset()
    {
        self::$orderedFootnotes = [];
        self::$unorderedFootnotes = [];
    }
}
