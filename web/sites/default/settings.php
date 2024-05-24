<?php

/**
 * The default list of directories that will be ignored by Drupal's file API.
 *
 * By default ignore node_modules and bower_components folders to avoid issues
 * with common frontend tools and recursive scanning of directories looking for
 * extensions.
 *
 * @see \Drupal\Core\File\FileSystemInterface::scanDirectory()
 * @see \Drupal\Core\Extension\ExtensionDiscovery::scanDirectory()
 */
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

$settings['config_sync_directory'] = '../config/sync';

// Automatically generated include for settings managed by ddev.
$ddev_settings = dirname(__FILE__) . '/settings.ddev.php';
if (getenv('IS_DDEV_PROJECT') == 'true' && is_readable($ddev_settings)) {
  require $ddev_settings;
}

// Load the site name from the first part of the host name.
$hostname = explode('.', $_SERVER['HTTP_HOST'] ?? 'default');
$site = $hostname[0];
$environment = $hostname[1];
$base_domain = implode('.', array_splice($hostname, 1));
$operations_domain = 'https://operations.' . $base_domain;

// Create database based on hostname.
$database = strtr($_SERVER['HTTP_HOST'], ['.' => '']);
$database_hostname = $databases['default']['default']['host'];
$username = 'root';
$password = 'root';

$new_username = $databases['default']['default']['username'];

try {
  $conn = new PDO("mysql:host=$database_hostname;", $username, $password);
  $conn->query("CREATE DATABASE IF NOT EXISTS {$database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
  $conn->query("GRANT ALL ON $database.* TO '$new_username'@'%' IDENTIFIED BY '$password'");

  // Set database and username to new values.
  $databases['default']['default']['database'] = $database;

  // @TODO: This is setting username and password to ROOT. Figure out why GRANT isn't working.
  $databases['default']['default']['username'] = $username;
  $databases['default']['default']['password'] = $password;

} catch (PDOException $e) {

  // If unable to create or grant, don't change anything.

}
$site = $_SERVER['HTTP_HOST'];
$settings['config_sync_directory'] = '../config/' . $site . '/sync';
$settings['file_public_path'] = 'files/' . $site;
$settings['file_private_path'] = '../private/' . $site;
$settings['file_temp_path'] = '/tmp/';

#make sure this is different for every site using this codebase.
$settings['hash_salt'] .= $site . $environment;