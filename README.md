INTRODUCTION
------------
Integrates the Clipboard.js library with Drupal.

REQUIREMENTS
------------
 * clipboard.js library - https://github.com/zenorocha/clipboard.js/archive/master.zip

INSTALLATION
------------
1. Download and extract the clipboard.js plugin, rename extracted folder to
   "clipboard" and copy it into "sites/all/libraries". The plugin should
   now be located at "sites/all/libraries/clipboard.js/dist/clipboard.js". You can
   also just use 'drush cbdl' to automatically download the library.

USAGE
-----
The Clipboard.js can be added to any text field by visiting the manage display
page for the entity and choosing Clipboard.js as the field formatter.

Custom form fields can also use clipboard.js using the form api or in a render
array using the theme function to display the element:

    ```PHP
      $form['clipboardjs'] = [
        '#theme' => 'clipboardjs_button',
        '#value' => 'Any copyable value.',
      ];
    ```

or a full example of one of the available templates e.g., clipboardjs_button,
clipboardjs_snippet, clipboardjs_textarea or clipboardjs_textfield:

    ```PHP
    $form['clipboardjs'] = [
      '#type' => 'item',
      '#theme' => 'clipboardjs_textfield',
      '#title' => $this->t('Clipboard.js Textfield'),
      '#value' => 'Any copyable value.',
      '#label' => $this->t('Click to copy'),
      '#alert_style' => 'tooltip', // e.g., 'tooltip', 'alert' or 'none'
      '#alert_text' => $this->t('Copied!'),
    ];
    ```

CREDITS
-------
Drupal 8/9/10 - Development, Maintenance
* Stefan Auditor - [sanduhrs](https://www.drupal.org/u/sanduhrs)

Initial Development
* Norman Kerr - [kenianbei](https://www.drupal.org/u/kenianbei)
