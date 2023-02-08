<?php

namespace Drupal\backup_db;

/**
 * Backup Database File class.
 */
class BackupDatabaseFile {

  /**
   * The filename.
   *
   * @var Filename
   */
  protected $name;

  /**
   * The file type.
   *
   * @var Filetype
   */
  protected $type;

  /**
   * The file uri.
   *
   * @var Fileuri
   */
  protected $uri;

  /**
   * Return the file name.
   */
  public function getFileName() {
    return $this->name;
  }

  /**
   * Set the file uri.
   */
  public function setFileName($name) {
    $this->name = $name;
  }

  /**
   * Return the file type.
   */
  public function getFileType() {
    return $this->type;
  }

  /**
   * Set the file type.
   */
  public function setFileType($type) {
    $this->type = $type;
  }

  /**
   * Return the file uri.
   */
  public function getFileUri() {
    return $this->uri;
  }

  /**
   * Set the file uri.
   */
  public function setFileUri($uri) {
    $this->uri = $uri;
  }

}
