<?php

class zsDoctrineRecordBuilder
{

  public function addBuilder (array $description)
  {
    $builder = new zsRecordBuilder($description);
    $this->builders[$description['name']] = $builder;
    return $builder;
  }

  /**
   * 
   * @var array
   */
  private $builders = array();

  /**
   * @return array the $__builders
   */
  public function getBuilders ()
  {
    return $this->builders;
  }

  public function getBuilder ($name)
  {
    if (empty($name)) {
      throw new InvalidArgumentException('Argument $name is empty');
    }
    
    if ($b = @$this->builders[$name]) {
      return $b;
    }
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}