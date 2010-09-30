<?php

class zsRecordBuilder
{

  /**
   * 
   * @var zsRecordBuilderDescription
   */
  private $description;

  public function __construct (array $description, zsRecordBuilderContext $context = null)
  {
    $this->description = new zsRecordBuilderDescription($description);
  }

  public function build ()
  {
    $class = $this->description->getModel();
    $model = new $class();
    
    foreach ($this->description->getAttributes() as $attr => $value) {
    	$model->$attr = $value;
    }
    
    return $model;
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}