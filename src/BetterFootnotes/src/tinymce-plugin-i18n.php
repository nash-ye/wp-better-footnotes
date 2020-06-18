<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$strings =
  'tinyMCE.addI18n({
    '. _WP_Editors::$mce_locale .': {
      betterFootnotes: {
        insertFootnoteTitle: "' . esc_js(__('Insert Footnote', 'better-footnotes')) . '",
      }
    }
  });';
