<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * test case.
 */
class zsRecordBuilderTest extends PHPUnit_Framework_TestCase
{
  
  protected function tearDown()
  {
    zsRecordBuilderContext::getInstance()->cleanBuilders();
  }
  
  /**
   * @testdox __construct() accept an array as parameter
   */
  public function recordBuilderConstruct()
  {
    $builder = new zsRecordBuilder(array('model' => 'User', 'name' => 'stephane'));
  }
  
  /**
   * @testdox build() return an instance of Doctrine_Record
   */
  public function buildReturnDoctrine_Record()
  {
    $builder = new zsRecordBuilder(array('model' => 'User', 'name' => 'stephane'));
    $this->assertType('Doctrine_Record', $builder->build());
  }
  
  /**
   * @testdox build() return an instance of the expected Doctrine_Record subtype
   * @dataProvider buildReturnDoctrine_RecordSubtypeProvider
   */
  public function buildReturnDoctrine_RecordSubtype($type)
  {
    $builder = new zsRecordBuilder(array('model' => $type, 'name' => 'stephane'));
    $this->assertType($type, $builder->build());
  }
  
  public static function buildReturnDoctrine_RecordSubtypeProvider()
  {
    return array(
      array('User'),
      array('Phonenumber'),
      array('Group'),
      array('Email'),
    );
  }
  
  /**
   * @testdox the builded instance should match specified attributes passed to the contructor
   * @dataProvider buildedInstanceMatchSpecifiedAttributesProvider
   */
  public function buildedInstanceMatchSpecifiedAttributes(array $data, zsRecordBuilderDescription $description)
  {
    $builder = new zsRecordBuilder($data);
    $record = $builder->build();
    
    foreach ($description->getAttributes() as $attr => $value) {
    	$this->assertEquals($value, $record->$attr);
    }
  }
  
  public static function buildedInstanceMatchSpecifiedAttributesProvider()
  {
    return array_map(function (array $d)
    {
      return array($d, new zsRecordBuilderDescription($d));
    }, 
    zsRecordBuilderDescriptionProvider::getValidDescriptionsWithAttributes());
  }
  
  
  /**
   * @testdox build() returned instance should have relations properly builded for one to one relations
   * @dataProvider buildedInstanceOkWithOneToOneProvider
   */
  public function buildedInstanceOkWithOneToOne(array $data, zsRecordBuilderDescription $description)
  {
    //prepare
    foreach (zsRecordBuilderDescriptionProvider::getValidDescriptionsWithOneToOneRelation() as $d) {
      zsRecordBuilderContext::getInstance()->addBuilder($d);
    }
    unset($d);
    
    //
    $builder = new zsRecordBuilder($data);
    $record = $builder->build();
    
    foreach ($description->getRelations() as $relation => $builderName) {
      $expectedClass = get_class(zsRecordBuilderContext::getInstance()->getBuilder($builderName)->build());
      
      $this->assertType(Doctrine_Record, $record->$relation);
      $this->assertType($expectedClass, $record->$relation);
    }
  }
  
  //testing the provider
  public function testBuildedInstanceOkWithOneToOneProvider()
  {
    $this->assertTrue(count($this->buildedInstanceMatchSpecifiedAttributesProvider()) > 0);
  }
  
  public static function buildedInstanceOkWithOneToOneProvider()
  {
    return array_filter(array_map(function (array $d) 
    {
      if(@$d['relations'])
      {
        return array($d, new zsRecordBuilderDescription($d));
      }
    }, 
    zsRecordBuilderDescriptionProvider::getValidDescriptionsWithOneToOneRelation()));
  }
  
  /**
   * @testdox when building a relation for a collection, it should accept a single builder reference
   * @dataProvider buildingManyAcceptOneBuilderProvider
   */
  public function buildingManyAcceptOneBuilder(array $data, zsRecordBuilderDescription $description)
  {
    //prepare
    foreach (zsRecordBuilderDescriptionProvider::getValidDescriptionsForManyRelationWithOneBuilder() as $d) {
      zsRecordBuilderContext::getInstance()->addBuilder($d);
    }
    unset($d);
    
    //
    $builder = new zsRecordBuilder($data);
    $record = $builder->build();
    
    foreach ($description->getRelations() as $relations => $builderName) {
      $expectedClass = get_class(zsRecordBuilderContext::getInstance()->getBuilder($builderName)->build());
      
      $this->assertType(Doctrine_Record, $record->$relations->getFirst());
      $this->assertType($expectedClass, $record->$relations->getFirst());
    }
  }
  
  //testing the provider
  public function testBuildingManyAcceptOneBuilderProvider()
  {
    $this->assertTrue(count($this->buildingManyAcceptOneBuilderProvider()) > 0);
  }
  
  public static function buildingManyAcceptOneBuilderProvider()
  {
    return array_filter(array_map(function (array $d)
    {
      if(@$d['relations'])
      {
        return array($d, new zsRecordBuilderDescription($d));
      }
    }, 
    zsRecordBuilderDescriptionProvider::getValidDescriptionsForManyRelationWithOneBuilder()));
  }
   
   
   
   
   
   
   
   
   
}