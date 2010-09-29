<?php

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * test case.
 */
class zsDoctrineRecordBuilderTest extends PHPUnit_Framework_TestCase
{

  /**
   * @testdox doctrine is loaded
   */
  public function doctrineLoaded()
  {
    $this->assertNotNull(Doctrine_Core::getPath());
  }
}

