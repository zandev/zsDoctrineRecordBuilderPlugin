<?php

require_once 'PHPUnit/Framework/TestSuite.php';

require_once __DIR__ . '/lib/builder/zsRecordBuilderContextTest.php';
require_once __DIR__ . '/lib/builder/zsRecordBuilderDescriptionTest.php';
require_once __DIR__ . '/lib/builder/zsRecordBuilderTest.php';

require_once __DIR__ . '/bootstrap/unit.php';
/**
 * Static test suite.
 */
class TestRunner extends PHPUnit_Framework_TestSuite
{

  /**
   * Constructs the test suite handler.
   */
  public function __construct ()
  {
    $this->setName('TestRunner');
    
    $this->addTestSuite('zsArrayRecordBuilderTest');
    $this->addTestSuite('zsClosureRecordBuilderTest');
    $this->addTestSuite('zsRecordBuilderContextTest');
    $this->addTestSuite('zsRecordBuilderDescriptionTest');
    $this->addTestSuite('zsRecordBuilderDescriptionParserTest');
  }

  /**
   * Creates the suite.
   */
  public static function suite ()
  {
    return new self();
  }
}

