<?php

namespace Drupal\clipboardjs\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'clipboardjs_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'clipboardjs.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('clipboardjs.settings');
    //someday we might make the alts configurable, but we would need to perform substitutions 
    //or build SCSS to load the correct CSS.  Now we choose between two pairs.
    $form['css_override'] = [
      '#type' => 'checkbox',
      '#default_value' => $config->get('css_override'),
      '#title' => $this->t('Use alternate classnames'),
      '#description' => $this->t('To manage js trigger and css conflicts, 
        use alternate classes.  Instead of "%deftip" and "%deftxt" classes,
        selecting this option will use "%alttip" and "%alttxt" as selectors.', [
      '%deftip' => $config->get('def_tooltipclass'),
      '%deftxt' => $config->get('def_tooltxtclass'),
      '%alttip' => $config->get('alt_tooltipclass'),
      '%alttxt' => $config->get('alt_tooltxtclass'),
      ]),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('clipboardjs.settings')
      ->set('css_override', $form_state->getValue('css_override'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}