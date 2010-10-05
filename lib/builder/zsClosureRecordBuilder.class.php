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

  public function __construct (Closure $closure, zsRecordBuilderContext $context = null)
  {
    $this->closure = $closure;
    $this->context = $context ? $context : zsRecordBuilderContext::getInstance();
  }

  public function build($withRelations = true)
  {
    $class = $this->closure->getModel();
    $model = new $class();
    
    return $model;
  }
  
  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}