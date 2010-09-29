<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * zsRecordBuilderDescription test case.
 */
class zsRecordBuilderDescriptionTest extends PHPUnit_Framework_TestCase
{
  
  public static function zsRecordBuilderDescriptionProvider()
  {
    $descriptions = array(
      array(
        'model'   => 'User', 
        'name'    => 'stephane', 
        'attributes' => array(
          'username'  => 'zanshine',
          'firstname' => 'stephane',
          'lastname'  => 'richard',
        ),
        'relations' => array(
          'group'     => 'admin',
          'email'     => 'stephane@zanshine.com'
        ),
      ),
      array(
        'model'   => 'Email', 
        'name'    => 'stephane@zanshine.com', 
        'attributes' => array(
          'address'  => 'stephane@zanshine.com',
        ),
        'relations' => array(
          'user'     => 'stephane',
        ),
      ),
    );
    
    return array_map(function (array $d){
    	return array($d, new zsRecordBuilderDescription($d));
    }, $descriptions);
    
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
   * @testdox zsRecordBuilderDescription->getRelations() OK
   * @dataProvider zsRecordBuilderDescriptionProvider
   */
  public function getRelationsOK (array $data, zsRecordBuilderDescription $description) 
  {
    $this->assertEquals($data['relations'], $description->getRelations());
  }

}

