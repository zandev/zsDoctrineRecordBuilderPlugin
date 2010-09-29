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
  if(file_exists($path))
  {      
    require_once ($path);
    return true;
  }
  return false;
});

spl_autoload_register(function($className)
{
  $file = $className . '.class.php';
  $path = __DIR__ . '/../lib/builder/' . $file;
  if(file_exists($path))
  {      
    require_once ($path);
    return true;
  }
  return false;
});

$manager = Doctrine_Manager::getInstance();