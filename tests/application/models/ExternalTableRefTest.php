<?php
require_once 'TestConfiguration.php';

class models_ExternalTableRefTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Reset database to known state
        TestConfiguration::setupDatabase();
    }

    public function testSuiteIsComplete()
    {
        $this->assertTrue(false);
    }

}
