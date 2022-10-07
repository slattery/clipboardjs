<?php

namespace Drupal\clipboardjs\Plugin\Field\FieldFormatter;

/**
 * Plugin implementation of the 'clipboard' formatter.
 *
 * @FieldFormatter(
 *   id = "clipboard_fieldablepath",
 *   label = @Translation("Clipboard.js Button for the Fieldable Path"),
 *   field_types = {
 *     "fieldable_path"
 *   }
 * )
 */
class ClipboardJsFieldablePath extends ClipboardJsBase {

  const TEMPLATE = 'clipboardjs_fieldablepath';

}
