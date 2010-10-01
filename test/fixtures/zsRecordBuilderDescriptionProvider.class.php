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
    return self::getFixtures('valid descriptions for many relation with many builders');
  }
  
  public static function getValidDescriptions()
  {
    $fixtures = self::getFixtures('valid descriptions for many relation with many builders');
    foreach (self::getValidDescriptionsWithCallables() as $fixture) 
    {
    	$fixtures = array_merge($fixture, $fixtures);
    }
    return $fixtures;
  }
  
  public static function getValidDescriptionsWithCallables()
  {
    return array(
      array(array(
        'name' => 'stephane',
        'model' => 'User',
        'attributes' => array(
          'firstname' => array('uniqid')
        ),
        'relations' => array(
          'firstname' => array('Class', 'method')
        ),
      )),
      array(array(
        'name' => 'stephane',
        'model' => 'User',
        'attributes' => array(
          'firstname' => function() { return uniqid();},
        ),
      )),
    );
  }
  
  public static function getInvalidDescriptions()
  {
    return array(
      array(array()),
      array(array(
        'naem' => 'stephane', 
        'model' => 'User',
      )),
      array(array(
        'name' => 'stephane', 
        'modle' => 'User',
      )),
      array(array(
        'name' => 'stephane', 
        'model' => 'User',
        'attribute' => array(
        ),
      )),
      array(array(
        'name' => 'stephane', 
        'model' => 'User',
        'attributes' => array(
        ),
        'rlations' => array(
        ),
      )),
      array(array(
        'name' => 'stephane', 
        'model' => 'User',
        'attributes' => array(
        ),
        'relations' => array(
        ),
        'unknow' => array(
        ),
      )),
      array(array(
        'name' => 'stephane', 
        'model' => 'User',
        'attributes' => 'property',
        'relations' => array(
        ),
      )),
      array(array(
        'name' => 'stephane', 
        'model' => 'User',
        'attributes' => 'property',
        'relations' => array(
          'property' => 'value'
        ),
      )),
    );
  }
}










































