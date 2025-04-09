<?php

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all environments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to ensure that
 *      the site settings remain consistent.
 */
include __DIR__ . "/settings.pantheon.php";

$settings['config_sync_directory'] = '../config/default';

if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {
  switch ($_ENV['PANTHEON_ENVIRONMENT']) {
    case "test": case "live": {
    $config["config_split.config_split." . $_ENV['PANTHEON_ENVIRONMENT']]['status'] = true;
    break;
  }
    default: {
      $config["config_split.config_split.dev"]['status'] = true;
      break;
    }
  }
}
else {
  $config["config_split.config_split.local"]['status'] = true;
}

$settings['state_cache'] = TRUE;

// Add the following command to enable use of the sendmail functionality.
$settings['mailer_sendmail_commands'] = [
  '/usr/sbin/sendmail -t'
];

/**
 * Skipping permissions hardening will make scaffolding
 * work better, but will also raise a warning when you
 * install Drupal.
 *
 * https://www.drupal.org/project/drupal/issues/3091285
 */
// $settings['skip_permissions_hardening'] = TRUE;

// Automatically generated include for settings managed by ddev.
if (getenv('IS_DDEV_PROJECT') == 'true' && file_exists(__DIR__ . '/settings.ddev.php')) {
  include __DIR__ . '/settings.ddev.php';
}

/**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}
