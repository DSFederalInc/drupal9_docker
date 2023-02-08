<?php

namespace Drupal\backup_db\Adapter;

use Drupal\backup_db\BackupDatabaseClientInterface;
use Drupal\file\Entity\File;
use Drupal\file\FileInterface;

/**
 * Backup Database Local Adapter class.
 */
class BackupDatabaseLocalAdapter implements BackupDatabaseAdapterInterface {

  /**
   * The backup client.
   *
   * @var \Drupal\backup_db\BackupDatabaseClientInterface
   */
  private $client;

  /**
   * The constructor.
   *
   * @param \Drupal\backup_db\BackupDatabaseClientInterface $client
   *   The backup client.
   */
  public function __construct(BackupDatabaseClientInterface $client) {
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   */
  public function export() {
    $handler = $this->client->getFileHandler();
    $handler->setupFile($this->client->getSettings());

    $file = $handler->getFile();
    $user = \Drupal::currentUser();

    // Create a file entity.
    $entity = File::create([
      'uri' => $file->getFileUri(),
      'uid' => $user->id(),
      'status' => FileInterface::STATUS_PERMANENT,
    ]);
    $entity->save();

    // Insert history entry.
    if ($entity->id()) {
      backup_db_history_insert([
        'fid' => $entity->id(),
        'name' => $file->getFileName(),
        'uri' => $file->getFileUri(),
      ]);

      $export = $this->client->dump();
      $export->start($file->getFileUri());
    }
    else {
      \Drupal::logger('backup_db')->error('File entity could not be created.');
    }

    return $entity->id();
  }

}
