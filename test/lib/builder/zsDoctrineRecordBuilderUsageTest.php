<?php

require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__ . '/../../../lib/helper/zsDoctrineRecordBuilderHelper.php';
/**
 * test case.
 */
class zsDoctrineRecordBuilderUsageTest extends PHPUnit_Framework_TestCase
{

   public function testData_1()
   {
     zs_add_builder('User', function($record){
       $record->firstname = 'My user name';
     });
     
     $this->assertEquals('My user name', zs_get_builder('User')->build()->firstname);
   }

}

