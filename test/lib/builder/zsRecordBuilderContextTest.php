<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * test case.
 */
class zsRecordBuilderContextTest extends PHPUnit_Framework_TestCase
{
  /**
   * 
   * @var zsRecordBuilder
   */
  private $builder;
  
  protected function setUp()
  {
    $this->builder = new zsRecordBuilderContext();
  }
  
  /**
   * @testdox doctrine is loaded
   */
  public function doctrineLoaded()
  {
    $this->assertNotNull(Doctrine_Core::getPath());
  }
  
  /**
   * @testdox addBuilder() api example
   */
  public function addBuilderAPI()
  {
    $this->builder->addBuilder(array(
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
  
  /**
   * @testdox addBuilder() return an instance of zsDoctrineBuilder
   */
  public function addBuilderReturnBuilderInstance()
  {
    $r =  $this->builder->addBuilder(array('model' => 'User', 'name' => 'stephane'));
    $this->assertType('zsRecordBuilder', $r);
  }
  
  /**
   * @testdox addBuilder()shoudl register the builder
   */
  public function addBuilderRegisterTheBuilderInstance()
  {
    $r = $this->builder->addBuilder(array('name' => 'stephane', 'model' => 'User'));
    $this->assertTrue(in_array($r, $this->builder->getBuilders()));
  }
  
  /**
   * @testdox after a call to addBuilder(), getBuilder('name') should return the correct instance
   */
  public function getBuilderReturnTheCorrectBuilder()
  {
    $r = $this->builder->addBuilder(array('name' => 'stephane', 'model' => 'User'));
    $this->assertEquals($r, $this->builder->getBuilder('stephane'));
  }
  
  /**
   * @testdox getInstance() without any parameters always return the first created instance
   */
  public function getInstanceReturnTheDefaultInstance()
  {
    $a = zsRecordBuilderContext::getInstance();
    
    for ($i = 0; $i < 3; $i++) {
    	$this->assertSame($a, zsRecordBuilderContext::getInstance());
    }
  }
  
  /**
   * @testdox the first instanciated object is is always the default one for getInstance()
   */
  public function firstInstanceIsAlwaysTheDefault()
  {
    $a = new zsRecordBuilderContext();
    
    for ($i = 0; $i < 3; $i++) {
      $b = new zsRecordBuilderContext();
      $this->assertTrue($a == zsRecordBuilderContext::getInstance());
    }
  }
  
  /**
   * @testdox cleanBuilders() remove all registered builders
   */
  public function cleanBuilders()
  {
    foreach (zsRecordBuilderDescriptionProvider::getValidDescriptionsWithAttributes() as $description) {
      zsRecordBuilderContext::getInstance()->addBuilder($description);
    }
    
    zsRecordBuilderContext::getInstance()->cleanBuilders();
    
    $this->assertEquals(0, count(zsRecordBuilderContext::getInstance()->getBuilders()));
  }
   
   
   
   
}








































