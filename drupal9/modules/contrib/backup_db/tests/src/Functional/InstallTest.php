<?php

namespace Drupal\Tests\backup_db\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Install test for module.
 *
 * @group backup_db
 */
class InstallTest extends BrowserTestBase {

  /**
   * Modules.
   *
   * @var string[]
   */
  public static $modules = ['backup_db'];

  /**
   * Install test.
   */
  public function testInstall() {
    $account = $this->createUser(['administer backup_db settings']);
    $this->drupalLogin($account);

    $this->drupalGet('/admin/config/backup_db/settings');
    $this->assertSession()->statusCodeEquals(200);
  }

}
