<?php

namespace Drupal\backup_db\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

/**
 * BackupDatabaseTablesForm class.
 */
class BackupDatabaseCronForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backup_db_cron';
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

    $form['cron_backup_enabled'] = [
      '#title' => $this->t('Enable local database backups on cron runs.'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('cron_backup_enabled'),
    ];

    $form['cron_interval'] = [
      '#title' => $this->t('Backup Interval (hours)'),
      '#type' => 'number',
      '#step' => '1',
      '#description' => $this->t('Number of hours to wait between backups.'),
      '#required' => TRUE,
      '#default_value' => $config->get('cron_interval'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('backup_db.settings')
      ->set('cron_interval', $form_state->getValue('cron_interval'))
      ->set('cron_backup_enabled', $form_state->getValue('cron_backup_enabled'))
      ->save();

    \Drupal::state()->set('backup_db.cron_next_backup', \Drupal::time()->getRequestTime() + ($form_state->getValue('cron_interval') * 60));
  }

}
