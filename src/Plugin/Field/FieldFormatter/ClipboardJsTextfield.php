<?php

namespace Drupal\clipboardjs\Plugin\Field\FieldFormatter;

/**
 * Plugin implementation of the 'clipboard' formatter.
 *
 * @FieldFormatter(
 *   id = "clipboard_textfield",
 *   label = @Translation("Clipboard.js Textfield"),
 *   field_types = {
 *     "email",
 *     "link",
 *     "string",
 *     "string_long"
 *   }
 * )
 */
class ClipboardJsTextfield extends ClipboardJsBase {

  const TEMPLATE = 'clipboardjs_textfield';

}
