<?php

namespace Drupal\backup_db;

/**
 * Describes the BackupDatabaseClient class.
 */
interface BackupDatabaseClientInterface {

  /**
   * Peform the database export.
   */
  public function dump();

}
