<?php

namespace Drupal\clipboardjs\Commands;

use Drush\Commands\DrushCommands;
use Drush\Drush;
use Drush\Exec\ExecTrait;

/**
 * Drush commandfile.
 */
class ClipboardJsCommands extends DrushCommands {

  const LIBRARY_VERSION = '2.0.10';

  const LIBRARY_DOWNLOAD_URL = 'https://github.com/zenorocha/clipboard.js/archive/v' . self::LIBRARY_VERSION . '.zip';

  const LIBRARY_DOWNLOAD_DESTINATION = 'clipboard.js';

  const LIBRARY_DESTINATION = 'libraries';

  /**
   * Command to download and extract the library.
   *
   * @usage clipboardjs-download
   *   Download the library
   *
   * @command clipboardjs:download
   * @aliases cbd
   */
  public function download() {
    $this->logger()->notice('Downloading library...');
    $this->downloadLibrary(self::LIBRARY_DOWNLOAD_URL, self::LIBRARY_DOWNLOAD_DESTINATION);
  }

  /**
   * Download and extract a library.
   *
   * @param string $url
   *   The URL to download.
   * @param string $destination
   *   The path to copy the files to.
   *
   * @throws \Exception
   */
  public function downloadLibrary($url, $destination) {
    if (!is_dir(self::LIBRARY_DESTINATION)) {
      drush_op('mkdir', self::LIBRARY_DESTINATION);
      $this->logger()->notice('Directory ' . self::LIBRARY_DESTINATION . ' was created.');
    }

    // Set the directory to the download location.
    $olddir = getcwd();
    chdir(self::LIBRARY_DESTINATION);

    // Download the archive.
    $filename = basename($url);
    if ($filepath = $this->downloadFile($url, FALSE, FALSE, \Drupal::service('file_system')->getTempDirectory() . '/' . $filename, TRUE)) {
      $filename = basename($url);

      // Remove any existing plugin directory.
      if (is_dir($destination)) {
        \Drupal::service('file_system')->deleteRecursive($destination);
      }

      // Decompress the archive.
      $zip = new \ZipArchive();
      if ($zip->open($filepath) === TRUE) {
        $index = $zip->getNameIndex(0);

        $zip->extractTo('.');
        $zip->close();

        \Drupal::service('file_system')->move($index, $destination);
        $this->logger()->notice('The library has been downloaded to ' . $destination);
      }
      else {
        throw new \Exception("Cannot extract '$filename', not a valid archive");
      }
    }

    // Set working directory back to the previous working directory.
    chdir($olddir);

    if (is_dir(self::LIBRARY_DESTINATION . '/' . $destination)) {
      $this->logger()->info('The plugin has been installed to ' . self::LIBRARY_DESTINATION . '/' . $destination);
    }
    else {
      $this->logger()->error('Drush was unable to install the plugin to ' . self::LIBRARY_DESTINATION . '/' . $destination);
    }
  }

  /**
   * Downloads a file.
   *
   * Optionally uses user authentication, using either wget or curl, as
   * available.
   *
   * @param string $url
   *   The URL to download.
   * @param string $user
   *   The username for authentication.
   * @param string $password
   *   The password for authentication.
   * @param string $destination
   *   The destination folder to copy the download to.
   * @param bool $overwrite
   *   Whether to overwrite an existing destination folder.
   *
   * @return string
   *   The destination folder.
   *
   * @throws \Exception
   */
  protected function downloadFile($url, $user = '', $password = '', $destination = '', $overwrite = TRUE) {
    static $use_wget;
    if ($use_wget === NULL) {
      $use_wget = ExecTrait::programExists('wget');
    }

    $destination_tmp = drush_tempnam('download_file');
    if ($use_wget) {
      $args = ['wget', '-q', '--timeout=30'];
      if ($user && $password) {
        $args = array_merge($args, [
          "--user=$user",
          "--password=$password",
          '-O',
          $destination_tmp,
          $url,
        ]);
      }
      else {
        $args = array_merge($args, ['-O', $destination_tmp, $url]);
      }
    }
    else {
      $args = ['curl', '-s', '-L', '--connect-timeout 30'];
      if ($user && $password) {
        $args = array_merge($args, [
          '--user',
          "$user:$password",
          '-o',
          $destination_tmp,
          $url,
        ]);
      }
      else {
        $args = array_merge($args, ['-o', $destination_tmp, $url]);
      }
    }
    $process = Drush::process($args);
    $process->mustRun();

    if (!$this->getConfig()->simulate()) {
      if (!drush_file_not_empty($destination_tmp) && $file = @file_get_contents($url)) {
        @file_put_contents($destination_tmp, $file);
      }
      if (!drush_file_not_empty($destination_tmp)) {
        // Download failed.
        throw new \Exception(dt("The URL !url could not be downloaded.", ['!url' => $url]));
      }
    }
    if ($destination) {
      \Drupal::service('file_system')
        ->move($destination_tmp, $destination, $overwrite);
      return $destination;
    }
    return $destination_tmp;
  }

}
