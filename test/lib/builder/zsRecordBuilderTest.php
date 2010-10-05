<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * zsRecordBuilder test case.
 */
class zsRecordBuilderTest extends PHPUnit_Framework_TestCase
{
  
  /**
   * @testdox construct should accept a String, a Closure and a builder context
   */
  public function constructArgumentsWithStringAsOptions()
  {
    $builder = new zsRecordBuilder('User', function(){}, zsRecordBuilderContext::getInstance());
    $this->assertType('User', $builder->build());
  }
  
  /**
   * @testdox construct should accept a Hash, a Closure and a builder context
   */
  public function constructArgumentsWithHashAsOptions()
  {
    $builder = new zsRecordBuilder(array('model' => 'User'), function(){}, zsRecordBuilderContext::getInstance());
    $this->assertType('User', $builder->build());
  }
  
  /**
   * @testdox construct do not accept an empty string as model
   * @expectedException InvalidArgumentException
   */
  public function constructRequireValidStringAsModel()
  {
    $builder = new zsRecordBuilder('', function(){});
  }
  
  /**
   * @testdox build() call the Closure
   */
  public function buildCallClosure()
  {
    $called = false;
    $builder = new zsRecordBuilder('User', function(Doctrine_Record $record)use(&$called){
      $called = true;
    });
    $builder->build();
    $this->assertTrue($called);
  }
   
  /**
   * @testdox build should pass an instance of doctrine record to the closure
   */
  public function buildPassRecordToClosure()
  {
    $scope = $this;
    $builder = new zsRecordBuilder('User', function(Doctrine_Record $record)use($scope){
      $scope->assertType('Doctrine_Record', $record);
    });
    $builder->build();
    $this->assertTrue(true);
  }
  
  /**
   * @testdox build should pass an instance of the expected type
   */
  public function buildPassExpectedTypeToClosure()
  {
    $scope = $this;
    $builder = new zsRecordBuilder('User', function(Doctrine_Record $record)use($scope){
      $scope->assertType('User', $record);
    });
    $builder->build();
    $this->assertTrue(true);
  }
  
  /**
   * @testdox build should apply closure body to the returned instance
   */
  public function closureAssignations()
  {
    zsRecordBuilderContext::getInstance()->addBuilder(array('model'  => 'Group', 'name' => 'admin'), function(Doctrine_Record $record){
        $record->name = 'Administrator';
    });
    
    $builder = new zsRecordBuilder('User', function(Doctrine_Record $record){
      $record->firstname = 'Dude';
      $record->lastname = 'TheBoss';
      $record->Groups[] = zsRecordBuilderContext::getInstance()->getBuilder('admin')->build();
    });
    
    $this->assertEquals('Dude', $builder->build()->firstname);
    $this->assertEquals('TheBoss', $builder->build()->lastname);
    $this->assertEquals('Administrator', $builder->build()->Groups->getFirst()->name);
  }
  
  /**
   * @testdox by extending another builder, the builded instance should inherit from it's parent
   */
  public function extendsInherit()
  {
    zsRecordBuilderContext::getInstance()->addBuilder(array('model'  => 'Group', 'name' => 'admin'), function(Doctrine_Record $record){
        $record->name = 'Administrator';
    });
    
    zsRecordBuilderContext::getInstance()->addBuilder('User', function(Doctrine_Record $record){
      $record->firstname = 'Dude';
      $record->lastname = 'TheBoss';
      $record->Groups[] = zsRecordBuilderContext::getInstance()->getBuilder('admin')->build();
    });
    
    $builder = new zsRecordBuilder(array('name' => 'richard', 'extends' => 'User'), function(Doctrine_Record $record){});
    
    $this->assertEquals(
      zsRecordBuilderContext::getInstance()->getBuilder('User')->build()->toArray(),
      $builder->build()->toArray()
    );
  }
  
  /**
   * @testdox by extending another builder, the builded instance should override the properties inherited from it's parent
   */
  public function extendsOverride()
  {
    zsRecordBuilderContext::getInstance()->addBuilder(array('model'  => 'Group', 'name' => 'admin'), function(Doctrine_Record $record){
        $record->name = 'Administrator';
    });
    
    zsRecordBuilderContext::getInstance()->addBuilder(array('model'  => 'Group', 'name' => 'webmaster'), function(Doctrine_Record $record){
        $record->name = 'Webmaster';
    });
    
    zsRecordBuilderContext::getInstance()->addBuilder('User', function(Doctrine_Record $record){
      $record->firstname = 'Dude';
      $record->lastname = 'TheBoss';
      $record->Groups[] = zsRecordBuilderContext::getInstance()->getBuilder('admin')->build();
    });
    
    $builder = new zsRecordBuilder(array('name' => 'richard', 'extends' => 'User'), function(Doctrine_Record $record){
      $record->lastname = 'richard';
      $record->Groups[] = zsRecordBuilderContext::getInstance()->getBuilder('webmaster')->build();
    });
  }
   
   
  
  
   
}

