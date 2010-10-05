<?php

final class zsRecordBuilder
{

  /**
   * @var zsRecordBuilderDescription
   */
  private $closure;
  
  public function getClosure ()
  {
    return $this->closure;
  }
  
  /**
   * @var zsRecordBuilderContext
   */
  private $context;

  public function getContext ()
  {
    return $this->context;
  }
  
  /**
   * @var string
   */
  private $model;

  public function getModel ()
  {
    return $this->model;
  }
  
  /**
   * @var string
   */
  private $parent;
  
  public function __construct ($options, Closure $closure, zsRecordBuilderContext $context = null)
  {
    if(empty($options))
    {
      throw new InvalidArgumentException('you should provide a valid model');
    }
    if(is_string($options))
    {
      $options = array('model' => $options);
    }
    
    if($parent = @$options['extends']) 
    {
      $this->parent = $parent;
      $this->model = zsRecordBuilderContext::getInstance()->getBuilder($parent)->getModel();
    }
    else 
    {
      $this->model = $options['model'];
    }
    
    $this->closure = $closure;
    $this->context = $context ? $context : zsRecordBuilderContext::getInstance();
  }

  public function build(object $object = null)
  {
    $class = $this->model;
    $model = $object ? $object : new $class();
    
    if($this->parent)
    {
      $builder = zsRecordBuilder::getContext()->getBuilder($this->parent)->getClosure();
      $builder($model);
    }
    
    $builder = $this->closure;
    $builder($model);
    
    return $model;
  }
  
  public function create()
  {
    $record = $this->build();
    $record->save();
    return $record;
  }
  
  public function stub()
  {
    return $this->build(new stdClass());
  }
  
  public function attributes()
  {
    return $this->build()->toArray();
  }
  
  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}