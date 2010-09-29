<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * test case.
 */
class zsDoctrineRecordBuilderTest extends PHPUnit_Framework_TestCase
{

  /**
   * @testdox doctrine is loaded
   */
  public function doctrineLoaded()
  {
    $this->assertNotNull(Doctrine_Core::getPath());
  }
  
  /**
   * @testdox test api
   */
  public function addBuilderAPI()
  {
    zsDoctrineRecordBuilder::addBuilder(array(
      'name' => 'stephane',
      'model' => 'User',
      'attributes' => array(
        'firstname' => 'stephane',
        'lastname' => 'Richard',
        'password' => array('Class', 'method'),
        'salt' => function(){return uniqid();},
        'group' => 'admin', //Will try to match a builder named admin for the relation 'group'
        'phonenumbers' => '00 33 3 67 45 24 33' // same as $stephane->phonenumers[]->number = '00 33 3 67 45 24 33'
      )
    ));
    $this->assertTrue(true);
  }
}

