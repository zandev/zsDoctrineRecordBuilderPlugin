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
        throw new InvalidArgumentException('addBuilder() expect at least one argument');
        break;
      }
      
      case 1:
      {
        if(is_array($args[0]))
        {
          $this->addArrayBuilder($args[0]);
        }
        break;
      }
      
      case 2:
      {
        if($args[1] instanceof Closure)
        {
          $this->addClosureBuilder($args[0], $args[1]);
        }
        else
        {
          throw new InvalidArgumentException('addBuilder() expect one or two parameters');
        }
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
    if(!@$description['name'] || empty($description['name']))
    {
      throw new InvalidArgumentException('addArrayBuilder() expect description to contain a valid name');
    }
    $builder = new zsArrayRecordBuilder($description);
    $this->builders[$description['name']] = $builder;
    return $builder;
  }
  
  public function addClosureBuilder($options, Closure $closure)
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
    
    $builder = new zsClosureRecordBuilder($options['model'], $closure);
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