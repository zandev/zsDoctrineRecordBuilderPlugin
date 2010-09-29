<?php

class zsDoctrineRecordBuilder
{

  public static function addBuilder()
  {
    
  }
  
  
  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}