<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * test case.
 */
class zsRecordBuilderTest extends PHPUnit_Framework_TestCase
{
  
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
  public function buildedInstanceMatchSpecifiedAttributes($description)
  {
    $builder = new zsRecordBuilder($description);
    $record = $builder->build();
    
    foreach ($description['attributes'] as $attr => $value) {
    	$this->assertEquals($value, $record->$attr);
    }
  }
  
  public static function buildedInstanceMatchSpecifiedAttributesProvider()
  {
    return array_map(function (array $d){
      return array($d, new zsRecordBuilderDescription($d));
    }, zsRecordBuilderDescriptionProvider::getValidDescriptionsWithAttributes());
  }
  
  
  /**
   * @_testdox build() returned instance should have one relation properly builded
   * @dataProvider buildedInstanceHaveOneRelationProvider
   */
  public function buildedInstanceHaveOneRelation($description)
  {
    foreach (zsRecordBuilderDescriptionProvider::getValidDescriptionsWithOneRelation() as $description) {
      zsRecordBuilderContext::getInstance()->addBuilder($description);
    }
    
    $builder = new zsRecordBuilder($description);
    $record = $builder->build();
    
    foreach ($description['relations'] as $relation => $builderName) {
      $expectedClass = get_class(new zsRecordBuilder($builderName));
      $this->assertEquals($builderName, $record->$relation);
    }
  }
  
  public static function buildedInstanceHaveOneRelationProvider()
  {
    return array_map(function (array $d){
      return array($d, new zsRecordBuilderDescription($d));
    }, zsRecordBuilderDescriptionProvider::getValidDescriptionsWithOneRelation());
  }
   
   
   
   
   
   
   
}