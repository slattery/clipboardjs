<?php

namespace Drupal\clipboardjs\Plugin\Field\FieldFormatter;

/**
 * Plugin implementation of the 'clipboard' formatter.
 *
 * @FieldFormatter(
 *   id = "clipboard_entityreference",
 *   label = @Translation("Clipboard.js Button for the Tax Entity Ref label"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class ClipboardJsEntityreference extends ClipboardJsBase {

  const TEMPLATE = 'clipboardjs_entityreference';

}
