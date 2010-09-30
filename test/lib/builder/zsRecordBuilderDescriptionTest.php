<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * zsRecordBuilderDescription test case.
 */
class zsRecordBuilderDescriptionTest extends PHPUnit_Framework_TestCase
{
  
  public static function zsRecordBuilderDescriptionProvider()
  {
    return array_map(function (array $d){
    	return array($d, new zsRecordBuilderDescription($d));
    }, zsRecordBuilderDescriptionProvider::getValidDescriptionsWithAttributes());
  }
  
  public static function zsRecordBuilderDescriptionWithRelationsProvider()
  {
    return array_map(function (array $d){
      return array($d, new zsRecordBuilderDescription($d));
    }, zsRecordBuilderDescriptionProvider::getValidDescriptionsWithRelations());
  }
  
  /**
   * @testdox __construct() accept an array, containing at least keys 'model' and 'name'
   * @dataProvider zsRecordBuilderDescriptionProvider
   */
  public function constructAcceptAnArrayWithModelAndName (array $data, zsRecordBuilderDescription $description) 
  {
    $this->assertTrue(true);
  }

  /**
   * @testdox zsRecordBuilderDescription->getModel() OK
   * @dataProvider zsRecordBuilderDescriptionProvider
   */
  public function getModelOK (array $data, zsRecordBuilderDescription $description) 
  {
    $this->assertEquals($data['model'], $description->getModel());
  }

  /**
   * @testdox zsRecordBuilderDescription->getName() OK
   * @dataProvider zsRecordBuilderDescriptionProvider
   */
  public function getNameOK (array $data, zsRecordBuilderDescription $description) 
  {
    $this->assertEquals($data['name'], $description->getName());
  }

  /**
   * @testdox zsRecordBuilderDescription->getAttributes() OK
   * @dataProvider zsRecordBuilderDescriptionProvider
   */
  public function getAttributesOK (array $data, zsRecordBuilderDescription $description) 
  {
    $this->assertEquals($data['attributes'], $description->getAttributes());
  }
  
  /**
   * @testdox getAttributes() return an empty array for empty values
   */
  public function getAttributesReturnEmptyArray()
  {
    $d = new zsRecordBuilderDescription(array('name' => 'stephane', 'model' => 'User'));
    $this->assertTrue(is_array($d->getAttributes()));
  }

  /**
   * @testdox zsRecordBuilderDescription->getRelations() OK
   * @dataProvider zsRecordBuilderDescriptionWithRelationsProvider
   */
  public function getRelationsOK (array $data, zsRecordBuilderDescription $description) 
  {
    $this->assertEquals($data['relations'], $description->getRelations());
  }
  
  /**
   * @testdox getRelations() return an empty array for empty values
   */
  public function getRelationsReturnEmptyArray()
  {
    $d = new zsRecordBuilderDescription(array('name' => 'stephane', 'model' => 'User'));
    $this->assertTrue(is_array($d->getRelations()));
  }

}

