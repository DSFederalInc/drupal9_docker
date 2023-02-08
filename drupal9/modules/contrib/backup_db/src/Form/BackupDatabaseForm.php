<?php

namespace Drupal\backup_db\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;

use Drupal\backup_db\Adapter\BackupDatabaseLocalAdapter;
use Drupal\backup_db\Adapter\BackupDatabaseRemoteAdapter;

/**
 * BackupDatabaseForm class.
 */
class BackupDatabaseForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backup_db_export';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('backup_db.settings');
    $site_name = \Drupal::config('system.site')->get('name');

    $form['filename'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Filename'),
      '#description' => $this->t('The prefix name of the sql dump file.'),
      '#default_value' => $config->get('filename') ? $config->get('filename') : $site_name,
    ];

    $form['type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Export type'),
      '#options' => [
        'local' => $this->t('Local'),
        'download' => $this->t('Download'),
      ],
      '#description' => $this->t('Export backup to local server or download.'),
      '#default_value' => 'download',
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Export'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    // Save filename.
    \Drupal::configFactory()->getEditable('backup_db.settings')
      ->set('filename', $values['filename'])
      ->save();

    // Call backup_db client.
    $client = \Drupal::service('backup_db.client');

    // Select our adapter.
    if ($values['type'] == 'download') {
      $handler = new BackupDatabaseRemoteAdapter($client);
    }

    if ($values['type'] == 'local') {
      $handler = new BackupDatabaseLocalAdapter($client);
    }

    // Run the export.
    if ($handler->export()) {
      $this->messenger()->addStatus(t('Backup has been successfully completed.'));
    }
    else {
      $this->messenger()->addWarning(t('Backup has failed, please review recent log messages.'));
    }
  }

}
