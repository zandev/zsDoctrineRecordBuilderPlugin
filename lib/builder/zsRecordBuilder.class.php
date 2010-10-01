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
    	$this->addAttribute($model, $attr, $value);
    }
    
    if ($withRelations) 
    {
      foreach ($this->description->getRelations() as $relations => $references)
      {
        if(is_array($references))
        {
          foreach($references as $builderName)
          {
            $this->addRelation($model, $relations, $builderName);
          }
        }
        else
        {          
          $this->addRelation($model, $relations, $references);
        }
      }
    }
    
    return $model;
  }
  
  private function addAttribute(Doctrine_Record $model, $attribute, $value)
  {
    if(is_array($value))
    {
      if(count($value) == 1) $value = current($value);
    }
    if (is_callable($value))
    {
      $value = call_user_func($value, $model);      
    }
    $model->$attribute = $value;
  }
  
  private function addRelation(Doctrine_Record $model, $relation, $builderName)
  {
    if ($model->$relation instanceof Doctrine_Collection)
    {
      $record = $this->context->getBuilder($builderName)->build(false);
      $model->$relation->add($record, $builderName);
    } 
    else 
    {
      $model->$relation = $this->context->getBuilder($builderName)->build(false);
    }
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}