<?php

namespace Drupal\backup_db\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;

/**
 * Backup Database History Form class.
 */
class BackupDatabaseHistoryForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backup_db_history';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $rows = []) {
    $header = [
      'fid' => 'fid',
      'name' => $this->t('Name'),
      'location' => $this->t('Location'),
      'created' => $this->t('Created'),
    ];

    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $rows,
      '#empty' => $this->t('No local export history found.'),
    ];

    if ($rows) {
      $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Delete'),
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $files = array_filter($values['table']);
    foreach ($files as $file) {
      backup_db_history_delete($file);
    }
  }

}
