=== Better Footnotes ===
Contributors: alex-ye
Tags: footnote, footnotes, bibliography, references
Requires at least: 4.0
Tested up to: 5.4.1
Requires PHP: 7.0
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.patreon.com/nash1ye

Simple yet powerful footnotes integration on your WordPress site.

== Description ==

Better Footnotes plugin lets you add footnotes on articles via shortcodes. It's extremely customizable, therefore it can be implemented on any theme.

= Main Features =
- Easy & flexible implementation.
- Animated scrolling effect (can be disabled).
- Footnotes can be implemented with shortcodes.

= Usage =

= Inserting a Footnote =
In order to insert a footnote, you can simply use the `[footnote]` shortcode as the following example:
`
[footnote]Your footnote here[/footnote]
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

= Contributing =
Developers can contribute to the source code on the [Github Repository](https://github.com/nash-ye/wp-better-footnotes).

== Installation ==

1. Upload and install the plugin
2. Use the plugin shortcodes.

== Changelog ==

= 1.1.1 =
* Hide footnotes section by default, and show it only when footnotes exist.
* Sanitize 'title_tag' and 'container' parameters in [footnotes] shortcode.
* Add 'post_id' parameter to [footnotes] shortcode.

= 1.1.0 =
* Switch to a client-side engine to render the footnotes.

= 1.0 =
* The Initial version.