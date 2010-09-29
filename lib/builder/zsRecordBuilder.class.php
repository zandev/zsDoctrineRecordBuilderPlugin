<?php

class zsRecordBuilder
{

  /**
   * 
   * @var zsRecordBuilderDescription
   */
  private $description;

  public function __construct (array $description)
  {
    $this->description = new zsRecordBuilderDescription($description);
  }

  public function build ()
  {
    $model = $this->description->getModel();
    return new $model();
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}