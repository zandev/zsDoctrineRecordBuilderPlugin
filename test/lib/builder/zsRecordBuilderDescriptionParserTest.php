<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * zsRecordBuilderDescriptionParser test case.
 */
class zsRecordBuilderDescriptionParserTest extends PHPUnit_Framework_TestCase
{

  public static function validDataProvider()
  {
    return array_map(function (array $d) {
      return array($d);
    }, zsRecordBuilderDescriptionProvider::getValidDescriptions());
  }
  
  public static function invalidDataProvider()
  {
    return array_map(function (array $d) {
      return array($d);
    }, zsRecordBuilderDescriptionProvider::getInvalidDescriptions());
  }
  
  /**
   * @testdox ::getInstance()
   */
  public function getInstance ()
  {
    $this->assertType('zsRecordBuilderDescriptionParser', zsRecordBuilderDescriptionParser::getInstance());
    $this->assertTrue(zsRecordBuilderDescriptionParser::getInstance() == zsRecordBuilderDescriptionParser::getInstance());
  }
  
  /**
   * @testdox parse() return the given description array on valid input
   * @dataProvider validDataProvider
   */
  public function parsePass(array $data)
  {
    $this->assertEquals($data, zsRecordBuilderDescriptionParser::getInstance()->parse($data));
  }
  
  /**
   * @testdox parseModel() fail on bad input
   * @expectedException zsRecordBuilderDescriptionParserException
   * @dataProvider invalidDataProvider
   */
  public function parseFail(array $data)
  {
    zsRecordBuilderDescriptionParser::getInstance()->parse($description);
  }

}

