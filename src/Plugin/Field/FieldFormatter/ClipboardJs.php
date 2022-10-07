<?php

namespace Drupal\clipboardjs\Plugin\Field\FieldFormatter;

/**
 * Plugin implementation of the 'clipboard' formatter.
 *
 * @deprecated in clipboardjs:2.0.2 and is removed from clipboardjs:2.1.0. Instead, use one of the other available formatters of this project.
 * // phpcs:ignore
 * @see https://git.drupalcode.org/project/clipboardjs/-/tree/2.0.x/src/Plugin/Field/FieldFormatter
 *
 * @FieldFormatter(
 *   id = "clipboard",
 *   label = @Translation("Clipboard"),
 *   field_types = {
 *     "email",
 *     "link",
 *     "text",
 *      "entity_reference",
 *     "string",
 *     "string_long"
 *   }
 * )
 */
class ClipboardJs extends ClipboardJsBase {

  const TEMPLATE = 'clipboardjs';

}
