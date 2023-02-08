<?php

namespace Drupal\backup_db\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

/**
 * Backup Database Tables Form class.
 */
class BackupDatabaseTablesForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backup_db_table';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['backup_db.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('backup_db.settings');
    $options = _backup_db_format_options(backup_db_show_tables());

    $form['include_tables'] = [
      '#type' => 'select',
      '#title' => $this->t('Include tables'),
      '#options' => $options,
      '#multiple' => TRUE,
      '#attributes' => [
        'size' => '8',
      ],
      '#description' => $this->t('Assign tables to include, leave empty for all.'),
      '#default_value' => $config->get('settings.include_tables'),
    ];

    $form['exclude_tables'] = [
      '#type' => 'select',
      '#title' => $this->t('Exclude tables'),
      '#options' => $options,
      '#multiple' => TRUE,
      '#attributes' => [
        'size' => '8',
      ],
      '#description' => $this->t('Assign tables to exclude, leave empty for none.'),
      '#default_value' => $config->get('settings.exclude_tables'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('backup_db.settings')
      ->set('settings.include_tables', $form_state->getValue('include_tables'))
      ->set('settings.exclude_tables', $form_state->getValue('exclude_tables'))
      ->save();
  }

}
