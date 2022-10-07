<?php

/**
 * @file
 * Drush integration for the clipboard.js module.
 *
 * @deprecated in 2.0.2 and is removed from 2.1.0.
 */

/**
 * Implements hook_drush_command().
 */
function clipboardjs_drush_command() {
  @trigger_error('Old style drush commands are deprecated in 2.0.2 and removed from 2.1.0. Instead, use a more modern version of drush..', E_USER_DEPRECATED);
  $items = [];
  $items['clipboard-download-library'] = [
    'description' => dt('Download and install clipboard.js library.'),
    'aliases' => ['cbdl'],
    'callback' => 'drush_clipboardjs_download_libraries',
  ];
  return $items;
}

/**
 * Drush command callback.
 *
 * @see clipboardjs_drush_command()
 */
function drush_clipboardjs_download_libraries() {
  @trigger_error('Old style drush commands are deprecated in 2.0.2 and removed from 2.1.0. Instead, use a more modern version of drush..', E_USER_DEPRECATED);
  if (!module_exists('libraries')) {
    return FALSE;
  }

  // Get base path.
  $base_path = drush_get_context('DRUSH_DRUPAL_CORE');

  // Get sites path.
  $site_path = (conf_path() == 'sites/default') ? 'sites/all' : conf_path();

  // Detect library.
  $library = libraries_detect('clipboard');

  // Creates a temp directory an change directory.
  drush_op('chdir', drush_tempdir());

  // Get library path and download link from library info.
  $library_path = $base_path . '/' . $site_path . '/libraries/clipboard';

  // Ask to overwrite if library already exists.
  if (\Drupal::service('file_system')->prepareDirectory($library_path)) {
    $confirm = drush_confirm('A version of clipboard.js already exists. Do you want to overwrite it?');
    if ($confirm) {
      drush_delete_dir($library_path, TRUE);
    }
    else {
      drush_log(dt('Skip installation of @name to @path.', ['@name' => 'clipboard', '@path' => $library_path]), 'warning');
      return;
    }
  }

  $download_url = '';
  if (!empty($library['download url'])) {
    $download_url = $library['download url'];
  }

  // Download and unzip into libraries.
  if (!empty($download_url)) {

    // Download the zip archive.
    $filename = drush_download_file($download_url);

    // Validate download exists.
    if (!file_exists($filename)) {
      return drush_set_error(dt('Unable to download @url.', ['@url' => $download_url]));
    }

    // Decompress the zip archive.
    $extract = drush_tarball_extract($filename, FALSE, TRUE);

    // Move directory.
    if (is_dir($extract[0]) && drush_move_dir($extract[0], $library_path)) {
      drush_log(dt('The @name library has been downloaded to @path.', ['@name' => 'clipboard', '@path' => $library_path]), 'success');
    }
    elseif (is_dir($extract[1]) && drush_move_dir($extract[1], $library_path)) {
      drush_log(dt('The @name library has been downloaded to @path.', ['@name' => 'clipboard', '@path' => $library_path]), 'success');
    }
    else {
      drush_set_error(dt('Unable to move @name library to @path.', ['@name' => 'clipboard', '@path' => $library_path]));
    }
  }

  // Return to base path.
  drush_op('chdir', $base_path);

  return NULL;
}
