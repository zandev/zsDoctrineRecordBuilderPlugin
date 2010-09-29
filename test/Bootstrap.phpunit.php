<?php

/**
 * Bootstrap Doctrine.php, register autoloader specify
 * configuration attributes and load models.
 */

require_once (__DIR__. '/../lib/vendor/doctrine/lib/Doctrine.php');

spl_autoload_register(function($className)
{
  $classPath = str_replace('_', '/', $className) . '.php';
  $path = __DIR__ . '/../lib/vendor/doctrine/lib/' . $classPath;
  require_once ($path);
  return true;
});

$manager = Doctrine_Manager::getInstance();