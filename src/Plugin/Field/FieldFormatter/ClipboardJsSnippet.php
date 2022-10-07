<?php

namespace Drupal\clipboardjs\Plugin\Field\FieldFormatter;

/**
 * Plugin implementation of the 'clipboard' formatter.
 *
 * @FieldFormatter(
 *   id = "clipboard_snippet",
 *   label = @Translation("Clipboard.js Snippet"),
 *   field_types = {
 *     "email",
 *     "link",
 *     "string",
 *     "string_long"
 *   }
 * )
 */
class ClipboardJsSnippet extends ClipboardJsBase {

  const TEMPLATE = 'clipboardjs_snippet';

}
