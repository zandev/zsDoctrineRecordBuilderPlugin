<?php

final class zsClosureRecordBuilder implements zsRecordBuilder
{

  /**
   * @var zsRecordBuilderDescription
   */
  private $closure;
  
  /**
   * @var zsRecordBuilderContext
   */
  private $context;
  
  /**
   * @var string
   */
  private $model;
  
  public function __construct ($model, Closure $closure, zsRecordBuilderContext $context = null)
  {
    if(empty($model))
    {
      throw new InvalidArgumentException('an empty string is not a valid model');
    }
    $this->model = $model;
    $this->closure = $closure;
    $this->context = $context ? $context : zsRecordBuilderContext::getInstance();
  }
  
  public function build($withRelations = true)
  {
    $class = $this->model;
    $model = new $class();
    
    $builder = $this->closure;
    $builder($model);
    
    return $model;
  }
  
  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}