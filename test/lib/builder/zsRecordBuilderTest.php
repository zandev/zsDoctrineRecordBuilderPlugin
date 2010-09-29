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
   
   
   
}