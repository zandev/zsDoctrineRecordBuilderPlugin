<?php

class zsRecordBuilderDescription
{

  public function __construct (array $description)
  {
    if (empty($description)) {
      throw new InvalidArgumentException('$description is empty');
    }
    
    $this->setModel(@$description['model']);
    $this->setName(@$description['name']);
    $this->setAttributes(@$description['attributes']);
    $this->setRelations(@$description['relations']);
  }

  private $model;

  private function setModel ($model)
  {
    if (empty($model)) {
      throw new InvalidArgumentException('$model is empty');
    }
    if (! $this->model) {
      $this->model = $model;
    }
  }

  public function getModel ()
  {
    return $this->model;
  }

  private $name;

  private function setName ($name)
  {
    if (empty($name)) {
      throw new InvalidArgumentException('$name is empty');
    }
    if (! $this->name) {
      $this->name = $name;
    }
  }

  public function getName ()
  {
    return $this->name;
  }

  private $attributes;

  private function setAttributes (array $attributes = null)
  {
    if (! $this->attributes) {
      $this->attributes = $attributes;
    }
  }

  public function getAttributes ()
  {
    return $this->attributes;
  }

  private $relations;

  private function setRelations (array $relations = null)
  {
    if (! $this->relations) {
      $this->relations = $relations;
    }
  }

  public function getRelations ()
  {
    return $this->relations;
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}