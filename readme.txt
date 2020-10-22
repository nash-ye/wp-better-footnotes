=== Better Footnotes ===
Contributors: alex-ye
Tags: footnote, footnotes, bibliography, references, notes
Requires at least: 4.0
Tested up to: 5.5
Requires PHP: 7.0
Stable tag: 1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.patreon.com/nash1ye

A robust solution to provide a fast reference and link to additional information for your readers

== Description ==

Better Footnotes is a robust and flexible solution that provides your article's readers with a fast reference and links to additional information.

Better Footnotes lets you add footnotes on articles easily and effortlessly using the visual editor or WordPress shortcodes. It's easy to use, customizable, and compatible with any WordPress theme.

= Main Features =
- Robust & flexible implementation.
- Visual editor buttons to add foonotes.
- Simple shortcodes to add or list footnotes.
- Animated footnotes scrolling effect, which can be disabled.

= Usage =

= Inserting a Footnote =
In order to insert a footnote, you can simply use the `[footnote]` shortcode as the following example:
`
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ex lacus, iaculis eget leo ac, tempus vestibulum mi. Curabitur dictum varius pharetra. Sed lobortis sem ac efficitur efficitur. [footnote]Your footnote here[/footnote]
`

*Shortcode Parameters*
- `type` Determines the type of the reference. Options: `numeric` / `non-numeric`.

= Listing Footnotes =
You can display the footnotes by using the shortcode `footnotes` as the following example:
`
[footnotes]
`
*Shortcode Parameters*
- `title` Determines the title for the footnotes list.
- `title_tag` Title tag name. Default is `h3`.

An active demo is available on [Arageek](https://www.arageek.com/) articles.

= Contributing =
Developers can contribute to the source code on the [Github Repository](https://github.com/nash-ye/wp-better-footnotes).

== Installation ==

1. Upload and install the plugin
2. Use the plugin shortcodes.

== Changelog ==

= 1.3 =
* Add "Auto Append" setting.

= 1.2 =
* Add TinyMCE footnote button.
* Add "BetterFootnotes\footnoteContent" filter.

= 1.1.1 =
* Hide footnotes section by default, and show it only when footnotes exist.
* Sanitize 'title_tag' and 'container' parameters in [footnotes] shortcode.
* Add 'post_id' parameter to [footnotes] shortcode.

= 1.1.0 =
* Switch to a client-side engine to render the footnotes.

= 1.0 =
* The Initial version.
