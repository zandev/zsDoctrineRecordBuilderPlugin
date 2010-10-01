<?php

final class zsRecordBuilderDescription
{

  public function __construct (array $description)
  {
    $data = zsRecordBuilderDescriptionParser::getInstance()->parse($description);
    
    $this->setModel($data['model']);
    $this->setName($data['name']);
    $this->setAttributes(@$data['attributes']);
    $this->setRelations(@$data['relations']);
  }

  private $model;

  private function setModel ($model)
  {
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
    return (array) $this->attributes;
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
    return (array) $this->relations;
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}