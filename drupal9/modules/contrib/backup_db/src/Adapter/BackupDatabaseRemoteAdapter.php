<?php

namespace Drupal\backup_db\Adapter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Drupal\backup_db\BackupDatabaseClientInterface;

/**
 * Backup Database Remote Adapter class.
 */
class BackupDatabaseRemoteAdapter implements BackupDatabaseAdapterInterface {

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
   * Export method.
   *
   * @return bool
   *   Returns the status.
   */
  public function export() {
    $handler = $this->client->getFileHandler();
    $handler->setupFile($this->client->getSettings());

    $file = $handler->getFile();

    $export = $this->client->dump();
    $export->start($file->getFileUri());

    $this->download($file->getFileUri(), [
      'name' => $file->getFileName(),
      'type' => $file->getFileType(),
    ]);

    return TRUE;
  }

  /**
   * Expose the export for download.
   *
   * @param string $path
   *   The path.
   * @param array $config
   *   The config array.
   */
  private function download($path, array $config) {
    $response = new BinaryFileResponse($path);
    $response->trustXSendfileTypeHeader();
    $response->headers->set('Content-Type', $config['type']);
    $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        $config['name']
    );
    $response->prepare(Request::createFromGlobals());
    $response->send();
  }

}
