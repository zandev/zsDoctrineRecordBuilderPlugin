<?php

require_once __DIR__ . '/../../../../config/ProjectConfiguration.class.php';

$app = sfConfig::get('app_test_application', 'frontend');

$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', isset($debug) ? $debug : true);
sfContext::createInstance($configuration);

$databaseManager = new sfDatabaseManager($configuration);

$cached_fixtures = sfConfig::get('sf_app_cache_dir') . '/test/fixtures/zsDoctrineRecordBuilder.yml';

if (! file_exists($cached_fixtures)) {
  if (! is_dir($dir = dirname($cached_fixtures))) {
    $fs = new sfFilesystem();
    $fs->mkdirs($dir);
  }
  $fh = fopen($cached_fixtures, 'w');
  fwrite($fh, 
  sfYaml::dump(sfYaml::load(sfConfig::get('sf_plugins_dir') . '/mhSimpleCatalogPlugin/test/fixtures/fixtures.yml'), 4));
  fclose($fh);
}
Doctrine_Core::loadData($cached_fixtures);