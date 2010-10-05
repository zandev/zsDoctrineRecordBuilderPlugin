<?php

final class zsRecordBuilderContext
{
  
  private static $defaultInstance;
  
  /**
   * @return zsRecordBuilderContext
   */
  public static function getInstance()
  {
    return self::$defaultInstance ? self::$defaultInstance : new self();
  }
  
  public function __construct()
  {
    if(!self::$defaultInstance) {
    	self::$defaultInstance = $this;
    }
  }
  
  public function addBuilder()
  {
    $args = func_get_args();
    
    switch (count($args)) {
      case 0:
      {
        ;
        break;
      }
      
      case 1:
      {
        ;
        break;
      }
      
      case 2:
      {
        ;
        break;
      }
      
      default:
      {
        ;
        break;
      }
    }
  }
  
  public function addArrayBuilder(array $description)
  {
    $builder = new zsArrayRecordBuilder($description);
    $this->builders[$description['name']] = $builder;
    return $builder;
  }
  
  public function addClosureBuilder($name, Closure $closure)
  {
    $builder = new zsClosureRecordBuilder($closure);
    $this->builders[$name] = $builder;
    return $builder;
  }

  /**
   * 
   * @var array
   */
  private $builders = array();

  /**
   * @return array the $__builders
   */
  public function getBuilders ()
  {
    return $this->builders;
  }
  
  /**
   * 
   * @param string $name
   * @return zsRecordBuilder
   */
  public function getBuilder ($name)
  {
    if (empty($name)) {
      throw new InvalidArgumentException('Argument $name is empty');
    }
    
    if ($b = @$this->builders[$name]) {
      return $b;
    }
  }
  
  public function cleanBuilders()
  {
    $this->builders = array();
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}