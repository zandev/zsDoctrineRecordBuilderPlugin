<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * zsRecordBuilderDescription test case.
 */
class zsRecordBuilderDescriptionTest extends PHPUnit_Framework_TestCase
{

  /**
   * @testdox __construct() accept an array, containing at least keys 'model' and 'name'
   */
  public function constructAcceptAnArrayWithModelAndName ()
  {
    $d = new zsRecordBuilderDescription(array('model' => 'User', 'name' => 'stephane'));
    $this->assertTrue(true);
  }

  /**
   * Tests zsRecordBuilderDescription->getModel()
   */
  public function getModelOK ()
  {
  }

  /**
   * Tests zsRecordBuilderDescription->getName()
   */
  public function getNameOK ()
  {
  }

  /**
   * Tests zsRecordBuilderDescription->getAttributes()
   */
  public function getAttributesOK ()
  {
  }

  /**
   * Tests zsRecordBuilderDescription->getRelations()
   */
  public function getRelationsOK ()
  {
  }

  /**
   * Tests zsRecordBuilderDescription->__set()
   */
  public function test__setOK ()
  {
  }

}

