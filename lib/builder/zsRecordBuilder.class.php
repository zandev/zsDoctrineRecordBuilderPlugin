<?php

final class zsRecordBuilder
{

  /**
   * @var zsRecordBuilderDescription
   */
  private $description;
  
  /**
   * @var zsRecordBuilderContext
   */
  private $context;

  public function __construct (array $description, zsRecordBuilderContext $context = null)
  {
    $this->description = new zsRecordBuilderDescription($description);
    $this->context = $context ? $context : zsRecordBuilderContext::getInstance();
  }

  public function build($withRelations = true)
  {
    $class = $this->description->getModel();
    $model = new $class();
    
    foreach ($this->description->getAttributes() as $attr => $value) 
    {
    	$model->$attr = $value;
    }
    
    if ($withRelations) 
    {
      foreach ($this->description->getRelations() as $relation => $builderName)
      {
        if ($model->$relation instanceof Doctrine_Collection)
        {
          $model->$relation->add($this->context->getBuilder($builderName)->build(false));
        } 
        else 
        {
          $model->$relation = $this->context->getBuilder($builderName)->build(false);
        }
      }
    }
    
    return $model;
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}