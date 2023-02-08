<?php

namespace Drupal\backup_db\Adapter;

/**
 * BackupDatabase Adapter Interface.
 */
interface BackupDatabaseAdapterInterface {

  /**
   * Perform the export.
   */
  public function export();

}
