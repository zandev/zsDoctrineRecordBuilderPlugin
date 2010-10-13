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
    zsRecordBuilderContext::cleanInstances();
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
    zsRecordBuilderContext::getInstance()->addBuilder('User', function(){});
    zsRecordBuilderContext::getInstance()->addBuilder('Broup', function(){});
    
    zsRecordBuilderContext::getInstance()->cleanBuilders();
    
    $this->assertEquals(0, count(zsRecordBuilderContext::getInstance()->getBuilders()));
  }
  
  /**
   * @testdox addBuilder() return an instance of zsDoctrineBuilder
   */
  public function addBuilderReturnBuilderInstance()
  {
    $r =  $this->builder->addBuilder(array('model' => 'User', 'name' => 'stephane'), function(){});
    $this->assertType('zsRecordBuilder', $r);
  }
  
  /**
   * @testdox addBuilder()shoudl register the builder
   */
  public function addBuilderRegisterTheBuilderInstance()
  {
    $r = $this->builder->addBuilder(array('name' => 'stephane', 'model' => 'User'), function(){});
    $this->assertTrue(in_array($r, $this->builder->getBuilders()));
  }
  
  /**
   * @testdox addBuilder() with a String return a valid builder
   */
  public function addBuilderWithStringReturnAValidBuilder()
  {
    $r = $this->builder->addBuilder('User', function(){});
    $r->build();
    $this->assertTrue(true);
  }
  
  /**
   * @testdox addBuilder() with a Hash return a valid builder
   */
  public function addBuilderWithHashReturnAValidBuilder()
  {
    $r = $this->builder->addBuilder(array('name' => 'stephane', 'model' => 'User'), function(){});
    $r->build();
    $this->assertTrue(true);
  }
  
  /**
   * @testdox addBuilder() with a inheritance return a valid builder
   */
  public function addBuilderWithInheritanceReturnAValidBuilder()
  {
    $this->builder->addBuilder(array('name' => 'stephane', 'model' => 'User'), function(){});
    $r = $this->builder->addBuilder(array('name' => 'richard', 'extends' => 'stephane'), function(){});
    $r->build();
    $this->assertTrue(true);
  }
  
  /**
   * @testdox after a call to addBuilder(String), getBuilder('name') should return the correct instance
   */
  public function getBuilderWithStringReturnTheCorrectBuilder()
  {
    $r = $this->builder->addBuilder('User', function(){});
    $this->assertEquals($r, $this->builder->getBuilder('User'));
  }
  
  /**
   * @testdox after a call to addBuilder(), getBuilder('name') should return the correct instance
   */
  public function getBuilderWithHashReturnTheCorrectBuilder()
  {
    $r = $this->builder->addBuilder(array('name' => 'stephane', 'model' => 'User'), function(){});
    $this->assertEquals($r, $this->builder->getBuilder('stephane'));
  }
  
  /**
   * @testdox addBuilder() proxies addClosureBuilder()
   */
  public function addBuilderProxies_addClosureBuilder()
  {
    zsRecordBuilderContext::getInstance()->addBuilder('closure builder', function(){});
    $this->assertType('zsRecordBuilder', zsRecordBuilderContext::getInstance()->getBuilder('closure builder'));
  }
   
   
   
   
   
   
}








































