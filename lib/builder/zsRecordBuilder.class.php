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
      $value = $value['callback'];
    }
    if (is_callable($value))
    {
      $value = call_user_func($value, $model);      
    }
    $model->$attribute = $value;
  }
  
  private function addRelation(Doctrine_Record $model, $relation, $builder)
  {
    if(is_array($builder))
    {
      $builder = $builder['callback'];
    }
    if(is_callable($builder))
    {
      $record = call_user_func($builder, $model);
    }
    else if($builder instanceof zsRecordBuilder)
    {
      $record = $builder->build();
    }
    else if(is_string($builder))
    {      
      $record = $this->context->getBuilder($builder)->build(false);
      $name = $builder;
    }
    
    if ($model->$relation instanceof Doctrine_Collection)
    {
      $model->$relation->add($record, $name);
    } 
    else 
    {
      $model->$relation = $record;
    }
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}