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
    
    foreach ($description->getAttributes() as $attr => $value)
    {
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
  
  /**
   * @testdox when building a relation for a collection, it should accept several builders references
   * @dataProvider buildingManyAcceptManyBuildersProvider
   */
  public function buildingManyAcceptManyBuilders(array $data, zsRecordBuilderDescription $description)
  {
    //prepare
    foreach (zsRecordBuilderDescriptionProvider::getValidDescriptionsForManyRelationWithManyBuilders() as $d)
    {
      zsRecordBuilderContext::getInstance()->addBuilder($d);
    }
    unset($d);
    
    //
    $builder = new zsRecordBuilder($data);
    $record = $builder->build();
    
    foreach ($description->getRelations() as $relation => $builders)
    {
      $i = 0;
      foreach ($builders as $builderName) 
      {
        ++$i;
        $expectedClass = get_class(zsRecordBuilderContext::getInstance()->getBuilder($builderName)->build());
        $this->assertType(Doctrine_Record, $record->$relation->get($builderName));
        $this->assertType($expectedClass, $record->$relation->get($builderName));
      }
    }
  }
  
  public function testBuildingManyAcceptManyBuildersProvider()
  {
    $this->assertTrue(count($this->buildingManyAcceptManyBuildersProvider()) > 0);
  }
  
  public static function buildingManyAcceptManyBuildersProvider()
  {
    return array_filter(array_map(function (array $d)
    {
      if(@$d['relations'])
      {
        return array($d, new zsRecordBuilderDescription($d));
      }
    }, 
    zsRecordBuilderDescriptionProvider::getValidDescriptionsForManyRelationWithManyBuilders()));
  }
  
  /**
   * @testdox it should build attributes from a callable function given in an array
   */
  public function itShouldBuildAttributeFromACallableFunction()
  {
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => array('callback' => 'give_me_a_firstname'),
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('User::' . __I_AM_A_CALL_BACK_FUNCTION__, $builder->build()->firstname);
  }
  
  /**
   * @testdox it should build attributes from a callable class/method pair given in an array
   */
  public function itShouldBuildAttributeFromACallableClassMethod()
  {
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => array('callback' => array('IAmACallback', 'getAttribute')),
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('User::' . IAmACallback::EXPECTED_ATTRIBUTE_VALUE, $builder->build()->firstname);
  }
  
  /**
   * @testdox it should build attributes from a closure given in an array
   */
  public function itShouldBuildAttributeFromAClosureInArray()
  {
    $scope = new stdClass();
    $scope->message = 'I come from a closure\'s return value';
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => array('callback' => function(Doctrine_Record $record)use($scope){
          return get_class($record) . '::' . $scope->message;
        }),
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('User::' . $scope->message, $builder->build()->firstname);
  }
  
  /**
   * @testdox it should build attributes from a closure
   */
  public function itShouldBuildAttributeFromAClosure()
  {
    $scope = new stdClass();
    $scope->message = 'I come from a closure\'s return value';
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => function(Doctrine_Record $record)use($scope){
          return get_class($record) . '::' . $scope->message;
        },
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('User::' . $scope->message, $builder->build()->firstname);
  }
  
  /**
   * @testdox it should build relations from callable function given in an array
   */
  public function isShouldBuildRelationFromACallableFunction()
  {
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => 'stephane',
      ),
      'relations' => array(
        'Groups' => array(
          array('callback' => 'give_me_a_group'),
        ),
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('give me a group', $builder->build()->Groups->getFirst()->name);
  }
  
  /**
   * @testdox it should build relations from valid class/method pair given in an array
   */
  public function isShouldBuildRelationFromACallableClassMethod()
  {
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => 'stephane',
      ),
      'relations' => array(
        'Groups' => array(
          array('callback' => array('IAmACallback', 'giveMeAGroup')),
        ),
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('IAmACallback giveMeAGroup', $builder->build()->Groups->getFirst()->name);
  }
  
  /**
   * @testdox it should build relations from a closure given in an array
   */
  public function isShouldBuildRelationFromACallableClosureInArray()
  {
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => 'stephane',
      ),
      'relations' => array(
        'Groups' => array(
          array('callback' => function(Doctrine_Record $record){
            $builder = new zsRecordBuilder(array('name' => 'admin', 'model' => 'Group', 'attributes' => array('name' => 'I come from a Closure')));
            return $builder->build(false);
          }),
        ),
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('I come from a Closure', $builder->build()->Groups->getFirst()->name);
  }
  
  /**
   * @testdox it should build relations from a closure
   */
  public function isShouldBuildRelationFromACallableClosure()
  {
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => 'stephane',
      ),
      'relations' => array(
        'Groups' => array(
          function(Doctrine_Record $record){
            $builder = new zsRecordBuilder(array('name' => 'admin', 'model' => 'Group', 'attributes' => array('name' => 'I come from a Closure')));
            return $builder->build(false);
          },
        ),
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('I come from a Closure', $builder->build()->Groups->getFirst()->name);
  }
  
  /**
   * @testdox it should build relations from a zsRecordBuilder instance given in an array
   */
  public function isShouldBuildRelationFromAzsRecordBuilderInstanceInArray()
  {
    $groupBuilder = new zsRecordBuilder(array('name' => 'admin', 'model' => 'Group', 'attributes' => array('name' => 'I come from a zsRecordBuilder')));
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => 'stephane',
      ),
      'relations' => array(
        'Groups' => array(
          array('callback' => $groupBuilder),
        ),
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('I come from a zsRecordBuilder', $builder->build()->Groups->getFirst()->name);
  }
  
  /**
   * @testdox it should build relations from a zsRecordBuilder instance
   */
  public function isShouldBuildRelationFromAzsRecordBuilderInstance()
  {
    $groupBuilder = new zsRecordBuilder(array('name' => 'admin', 'model' => 'Group', 'attributes' => array('name' => 'I come from a zsRecordBuilder')));
    $description = array(
      'name' => 'stephanerrichard',
      'model' => 'User',
      'attributes' => array(
        'firstname' => 'stephane',
      ),
      'relations' => array(
        'Groups' => array(
          $groupBuilder,
        ),
      ),
    );
    
    $builder = new zsRecordBuilder($description);
    
    $this->assertEquals('I come from a zsRecordBuilder', $builder->build()->Groups->getFirst()->name);
  }
   
   
}

define('__I_AM_A_CALL_BACK_FUNCTION__', 'I am a callback function');

function give_me_a_firstname(Doctrine_Record $record)
{
  return get_class($record) . '::' . __I_AM_A_CALL_BACK_FUNCTION__;
}

function give_me_a_group(Doctrine_Record $record) 
{
  $builder = new zsRecordBuilder(array('name' => 'admin', 'model' => 'Group', 'attributes' => array('name' => 'give me a group')));
	return $builder->build(false);
}

class IAmACallback
{
  const EXPECTED_ATTRIBUTE_VALUE = 'I am a callback method';
  
  public static function getAttribute(Doctrine_Record $record)
  {
    return get_class($record) . '::' . self::EXPECTED_ATTRIBUTE_VALUE;
  }
  
  public static function giveMeAGroup(Doctrine_Record $record)
  {
    $builder = new zsRecordBuilder(array('name' => 'admin', 'model' => 'Group', 'attributes' => array('name' => 'IAmACallback giveMeAGroup')));
    return $builder->build(false);
  }
}