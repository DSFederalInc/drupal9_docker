<?php

namespace Drupal\backup_db\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Datetime\Entity\DateFormat;
use Drupal\Core\StreamWrapper\PrivateStream;

/**
 * Backup Database Settings Form class.
 */
class BackupDatabaseSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backup_db_settings';
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

    // General.
    $form['path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Path'),
      '#description' => $this->t('The path database backups are saved to, should be a URI.'),
      '#default_value' => $config->get('path'),
    ];
    $date_types = DateFormat::loadMultiple();
    $date_formatter = \Drupal::service('date.formatter');
    $date_format_options = [];
    foreach ($date_types as $machine_name => $format) {
      $date_format_options[$machine_name] = $this->t('@name - @sample', [
        '@name' => $format->label(),
        '@sample' => $date_formatter->format(\Drupal::time()
          ->getRequestTime(), $machine_name),
      ]);
    }
    $form['date'] = [
      '#type' => 'select',
      '#title' => $this->t('Date format'),
      '#options' => $date_format_options,
      '#description' => $this->t('Creates sub folders inside path with date format name.'),
      '#default_value' => $config->get('date'),
    ];

    // Mysqldump settings.
    $form['compress'] = [
      '#type' => 'select',
      '#title' => $this->t('Compress'),
      '#options' => [
        'None' => $this->t('None'),
        'Gzip' => $this->t('Gzip'),
        'Bzip2' => $this->t('Bzip2'),
      ],
      '#description' => $this->t('Compress the database export.'),
      '#default_value' => $config->get('settings.compress'),
    ];
    $form['no_data'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('No data'),
      '#description' => $this->t('Do not write any table row information.'),
      '#default_value' => $config->get('settings.no_data'),
    ];
    $form['add_drop_table'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add drop table'),
      '#description' => $this->t('Write a DROP TABLE statement before each CREATE TABLE statement.'),
      '#default_value' => $config->get('settings.add_drop_table'),
    ];
    $form['single_transaction'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Single transaction'),
      '#description' => $this->t('Sets the transaction isolation mode to REPEATABLE READ and sends a START TRANSACTION SQL statement to the server before dumping data.'),
      '#default_value' => $config->get('settings.single_transaction'),
    ];
    $form['lock_tables'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Lock tables'),
      '#description' => $this->t('For each dumped database, lock all tables to be dumped before dumping them.'),
      '#default_value' => $config->get('settings.lock_tables'),
    ];
    $form['add_locks'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add locks'),
      '#description' => $this->t('Surround each table dump with LOCK TABLES and UNLOCK TABLES statements. This results in faster inserts when the dump file is reloaded.'),
      '#default_value' => $config->get('settings.add_locks'),
    ];
    $form['extended_insert'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Extended insert'),
      '#description' => $this->t('Write INSERT statements using multiple-row syntax that includes several VALUES lists. This results in a smaller dump file and speeds up inserts when the file is reloaded.'),
      '#default_value' => $config->get('settings.extended_insert'),
    ];
    $form['complete_insert'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Complete insert'),
      '#description' => $this->t('Use complete INSERT statements that include column names.'),
      '#default_value' => $config->get('settings.complete_insert'),
    ];
    $form['disable_keys'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Disable keys'),
      '#description' => $this->t('Makes loading the dump file faster because the indexes are created after all rows are inserted.'),
      '#default_value' => $config->get('settings.disable_keys'),
    ];
    $form['no_create_info'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('No create info'),
      '#description' => $this->t('Do not write CREATE TABLE statements that create each dumped table.'),
      '#default_value' => $config->get('settings.no_create_info'),
    ];
    $form['skip_triggers'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Skip triggers'),
      '#description' => $this->t('Include triggers for each dumped table in the output.'),
      '#default_value' => $config->get('settings.skip_triggers'),
    ];
    $form['add_drop_trigger'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add drop trigger'),
      '#description' => $this->t('Write a DROP TRIGGER statement before each CREATE TRIGGER statement.'),
      '#default_value' => $config->get('settings.add_drop_trigger'),
    ];
    $form['routines'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Routines'),
      '#description' => $this->t('Include stored routines (procedures and functions) for the dumped databases in the output. '),
      '#default_value' => $config->get('settings.routines'),
    ];
    $form['hex_blob'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hex blob'),
      '#description' => $this->t('Dump binary columns using hexadecimal notation.'),
      '#default_value' => $config->get('settings.hex_blob'),
    ];
    $form['databases'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Databases'),
      '#description' => $this->t('Treat all name arguments as database names.'),
      '#default_value' => $config->get('settings.databases'),
    ];
    $form['add_drop_database'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add drop database'),
      '#description' => $this->t('Write a DROP DATABASE statement before each CREATE DATABASE statement.'),
      '#default_value' => $config->get('settings.add_drop_database'),
    ];
    $form['skip_tz_utc'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Skip TZ UTC'),
      '#description' => $this->t('This option enables TIMESTAMP columns to be dumped and reloaded between servers in different time zones.'),
      '#default_value' => $config->get('settings.skip_tz_utc'),
    ];
    $form['no_autocommit'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('No autocommit'),
      '#description' => $this->t('Please see http://dev.mysql.com/doc/refman/5.7/en/commit.html'),
      '#default_value' => $config->get('settings.no_autocommit'),
    ];
    $form['skip_comments'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Skip comments'),
      '#description' => $this->t('Write additional information in the dump file such as program version, server version, and host.'),
      '#default_value' => $config->get('settings.skip_comments'),
    ];
    $form['skip_dump_date'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Skip dump date'),
      '#description' => $this->t('Produces a date comment at the end of the dump file.'),
      '#default_value' => $config->get('settings.skip_dump_date'),
    ];
    $form['default_character_set'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Default character set'),
      '#description' => $this->t('Please see http://dev.mysql.com/doc/refman/5.5/en/charset-unicode-utf8mb4.html'),
      '#default_value' => $config->get('settings.default_character_set'),
    ];
    $form['where'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Where'),
      '#description' => $this->t('Dump only rows selected by the given WHERE condition.'),
      '#default_value' => $config->get('settings.where'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!PrivateStream::basePath()) {
      // If value is private and not set.
      if (strpos($form_state->getValue('private'), '//private') !== FALSE) {
        $form_state->setErrorByName('private', $this->t('Private directory location not set in settings.php.'));
      }
      else {
        // Warn user that it should be private.
        $this->messenger()
          ->addWarning($this->t('Private directory is not set and should be used for backup storage.'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    // Save settings.
    $this->config('backup_db.settings')
      ->set('path', $values['path'])
      ->set('date', $values['date'])
      ->set('settings.compress', $values['compress'])
      ->set('settings.no_data', $values['no_data'])
      ->set('settings.add_drop_table', $values['add_drop_table'])
      ->set('settings.single_transaction', $values['single_transaction'])
      ->set('settings.lock_tables', $values['lock_tables'])
      ->set('settings.add_locks', $values['add_locks'])
      ->set('settings.extended_insert', $values['extended_insert'])
      ->set('settings.complete_insert', $values['complete_insert'])
      ->set('settings.disable_keys', $values['disable_keys'])
      ->set('settings.where', $values['where'])
      ->set('settings.no_create_info', $values['no_create_info'])
      ->set('settings.skip_triggers', $values['skip_triggers'])
      ->set('settings.add_drop_trigger', $values['add_drop_trigger'])
      ->set('settings.routines', $values['routines'])
      ->set('settings.hex_blob', $values['hex_blob'])
      ->set('settings.databases', $values['databases'])
      ->set('settings.add_drop_database', $values['add_drop_database'])
      ->set('settings.skip_tz_utc', $values['skip_tz_utc'])
      ->set('settings.no_autocommit', $values['no_autocommit'])
      ->set('settings.default_character_set', $values['default_character_set'])
      ->set('settings.skip_comments', $values['skip_comments'])
      ->set('settings.skip_dump_date', $values['skip_dump_date'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
