<?php
include_once __DIR__ . '/properties.php';
require_once __DIR__ . '/../../../../config/ProjectConfiguration.class.php';

$app = isset($app) ? $app : 'frontend';

$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', isset($debug) ? $debug : true);
sfContext::createInstance($configuration);

$databaseManager = new sfDatabaseManager($configuration);

Doctrine_Core::dropDatabases();
Doctrine_Core::createDatabases();
Doctrine_Core::generateModelsFromYaml(__DIR__ . '/../mock/config/doctrine/schema.yml', __DIR__ . '/../mock/lib/model', array('baseClassesDirectory' => 'base'));

Doctrine_Core::createTablesFromModels(__DIR__ . '/../mock/lib/model');