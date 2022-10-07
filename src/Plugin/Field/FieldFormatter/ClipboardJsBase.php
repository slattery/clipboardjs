<?php

namespace Drupal\clipboardjs\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Formatter plugins base.
 */



class ClipboardJsBase extends FormatterBase {

  const TEMPLATE = 'clipboardjs';

  const ALERT_STYLES = ['tooltip', 'alert', 'iconswap', 'none'];

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'label' => 'Click to copy',
      'alert_style' => 'tooltip',
      'alert_text' => 'Copied!',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#description' => $this->t('The label on the button or hovertip.'),
      '#default_value' => $this->getSetting('label'),
    ];
    $elements['alert_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Alert style'),
      '#description' => $this->t('The alert style e.g. <em>Tooltip</em>, <em>Alert</em> or <em>None</em>.'),
      '#default_value' => $this->getSetting('alert_style'),
      '#options' => array_combine(
        static::ALERT_STYLES,
        array_map(
          'ucfirst',
          static::ALERT_STYLES
        )
      ),
    ];
    $elements['alert_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Alert text'),
      '#description' => $this->t('The alert text, shown as tooltip or alert.'),
      '#default_value' => $this->getSetting('alert_text'),
    ];
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Label: @label', [
      '@label' => $this->getSetting('label'),
    ]);
    $summary[] = $this->t('Alert style: @alert_style', [
      '@alert_style' => $this->getSetting('alert_style'),
    ]);
    $summary[] = $this->t('Alert text: @alert_text', [
      '@alert_text' => $this->getSetting('alert_text'),
    ]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => static::TEMPLATE,
        // @codingStandardsIgnoreStart
        '#label' => $this->t($this->getSetting('label')),
        '#value' => $this->viewValue($item),
        '#alert_style' => $this->getSetting('alert_style'),
        '#alert_text' => $this->t($this->getSetting('alert_text')),
        // @codingStandardsIgnoreEnd
      ];
    }
    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // Link field support.
    if (method_exists($item, 'getUrl')) {
      return $item->getUrl();
    }

    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return $item->value;
  }

}
