<?php

class zsRecordBuilderDescriptionProvider
{
  
  private static $fixtures;
  
  public static function getFixtures($entry = null)
  {
    self::parseFixtures();
    
    if($entry)
    {
      if(!isset(self::$fixtures[$entry]))
      {
        throw new InvalidArgumentException("entry $entry is not set in fixtures");
      }
      return self::$fixtures[$entry];
    }
    return self::$fixtures;
  }
  
  private static function parseFixtures()
  {
    if(!self::$fixtures) {
      $data = sfYaml::load(__DIR__ . '/zs_record_builder_descriptions.yml');
      self::$fixtures = array();
      
      foreach ($data as $key => $value) {
        $dataSet = array();
        foreach ($value as $k => $v) {
          $v['name'] = $k;
          $dataSet[] = $v;
        }
        self::$fixtures[$key] = $dataSet;
      }
    }
  }
  
  public static function getValidDescriptionsWithAttributes()
  {
    return self::getFixtures('valid descriptions with attributes');
  }
  
  public static function getValidDescriptionsWithRelations()
  {
    return self::getFixtures('valid descriptions with relations');
  }
  
  
  public static function getValidDescriptionsWithOneToOneRelation()
  {
    return self::getFixtures('valid descriptions with one to one relation');
  }
  
  public static function getValidDescriptionsForManyRelationWithOneBuilder()
  {
    return self::getFixtures('valid descriptions for many relation with one builder');
  }
  
  public static function getValidDescriptionsForManyRelationWithManyBuilders()
  {
//    var_dump(self::getFixtures('valid descriptions for many relation with many builders'));die();
    return self::getFixtures('valid descriptions for many relation with many builders');
  }
}










































