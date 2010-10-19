<?php

/**
 * Copyright (C) 2010 Stéphane Robert Richard.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. Neither the name of the project nor the names of its contributors
 *    may be used to endorse or promote products derived from this software
 *    without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE PROJECT AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE PROJECT OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 * 
 */

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
   * @testdox construct do not accept an empty string as model
   * @expectedException InvalidArgumentException
   */
  public function constructRequireValidStringAsModel()
  {
    $builder = new zsRecordBuilder('', function(){});
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
    
    $this->assertEquals('richard', $builder->build()->lastname);
    $this->assertEquals(2, $builder->build()->Groups->count());
    $this->assertEquals('Administrator', $builder->build()->Groups->getFirst()->name);
    $this->assertEquals('Webmaster', $builder->build()->Groups->getLast()->name);
  }
   
  /**
   * @testdox create() should return a persisted object
   */
  public function createPersist()
  {
    $this->markTestIncomplete();
  }
  
  /**
   * @testdox stub() should return a stubbed object, an instance of stdClass with all record's properties and relations stubbed
   */
  public function stubReturnStdClassWithCorrectProperties()
  {
    $this->markTestIncomplete();
  }
  
  /**
   * @testdox attributes() should return an array of valid properties and relations
   */
  public function attributesReturnAnArrayOfProperties()
  {
    $this->markTestIncomplete();
  } 
   
   
  
  
   
}

