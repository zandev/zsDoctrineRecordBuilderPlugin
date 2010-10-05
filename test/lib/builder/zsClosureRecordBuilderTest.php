<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * zsClosureRecordBuilder test case.
 */
class zsClosureRecordBuilderTest extends PHPUnit_Framework_TestCase
{
  
  /**
   * @testdox construct should accept a String, a Closure and a builder context
   */
  public function constructArguments()
  {
    $builder = new zsClosureRecordBuilder('User', function(){}, zsRecordBuilderContext::getInstance());
    $this->assertTrue(true);
  }
  
  /**
   * @testdox construct do not accept an empty string as model
   * @expectedException InvalidArgumentException
   */
  public function constructRequireValidStringAsModel()
  {
    $builder = new zsClosureRecordBuilder('', function(){});
  }
  
  /**
   * @testdox build() call the Closure
   */
  public function buildCallClosure()
  {
    $called = false;
    $builder = new zsClosureRecordBuilder('User', function(Doctrine_Record $record)use(&$called){
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
    $builder = new zsClosureRecordBuilder('User', function(Doctrine_Record $record)use($scope){
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
    $builder = new zsClosureRecordBuilder('User', function(Doctrine_Record $record)use($scope){
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
    zsRecordBuilderContext::getInstance()->addArrayBuilder(array(
      'name' => 'admin',
      'model' => 'Group',
      'attributes' => array(
        'name' => 'Administrator'
      ),
    ));
    
    $builder = new zsClosureRecordBuilder('User', function(Doctrine_Record $record){
      $record->firstname = 'Dude';
      $record->lastname = 'TheBoss';
      $record->Groups[] = zsRecordBuilderContext::getInstance()->getBuilder('admin')->build();
    });
    
    $this->assertEquals('Dude', $builder->build()->firstname);
    $this->assertEquals('TheBoss', $builder->build()->lastname);
    $this->assertEquals('Administrator', $builder->build()->Groups->getFirst()->name);
  }
   
   
  
  
   
}

