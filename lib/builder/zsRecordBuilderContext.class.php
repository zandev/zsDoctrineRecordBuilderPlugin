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
  
  public function addBuilder($options, Closure $closure)
  {
    if(is_string($options))
    {
      $options = array('model' => $options, 'name' => $options);
    }
    if(!is_array($options))
    {
      throw new InvalidArgumentException('addClosureBuilder() expect first parameter to be either a string or a hash');
    }
    if(!@$options['name'])
    {
      throw new InvalidArgumentException('addClosureBuilder() options parameter expect at least a name');
    }
    if(!@$options['model'])
    {
      $options['model'] = $options['name'];
    }
    
    $builder = new zsRecordBuilder($options['model'], $closure);
    $this->builders[$options['name']] = $builder;
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
  
  public static function cleanInstances()
  {
    self::$defaultInstance = null;
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}