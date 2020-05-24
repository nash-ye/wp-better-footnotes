# WP Better Footnotes
A robust solution to provide a fast reference and link to additional information for your readers

## Description
Better Footnotes is a robust and flexible solution that provides your article's readers with a fast reference and links to additional information.

Better Footnotes lets you add footnotes on articles easily and effortlessly using the visual editor or WordPress shortcodes. It's easy to use, customizable, and compatible with any WordPress theme.

### Main Features:
- Robust & flexible implementation.
- Visual editor buttons to add foonotes.
- Simple shortcodes to add or list footnotes.
- Animated footnotes scrolling effect, which can be disabled.

## Usage

### Inserting a Footnote:
In order to insert a footnote, you can simply use the `[footnote]` shortcode as the following example:
```
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ex lacus, iaculis eget leo ac, tempus vestibulum mi. Curabitur dictum varius pharetra. Sed lobortis sem ac efficitur efficitur. [footnote]Your footnote here[/footnote]
```

#### Shortcode Parameters:
- `type` Determines the type of the reference. Options: `numeric` / `non-numeric`.

### Listing Footnotes:
You can display the footnotes by using the shortcode `footnotes` as the following example:
```
[footnotes]
```
#### Shortcode Parameters:
- `title` Determines the title for the footnotes list.
- `title_tag` Title tag name. Default is `h3`.

## Requirements
- PHP version 7.0 or higher.
