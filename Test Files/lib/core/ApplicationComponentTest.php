<?php

namespace lib\core;

/**
 * Classe dérivée de test
 */
class TestAppComponent extends ApplicationComponent
{
    
}

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-23 at 15:26:36.
 */
class ApplicationComponentTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ApplicationComponent
     */
    protected $object;

    /**
     * Une appli bidon
     * @var \lib\core\TestApplication
     */
    protected $app;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->app    = new \test\TestApplication();
        $this->object = new TestAppComponent($this->app);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers lib\core\ApplicationComponent::__construct
     * @covers lib\core\ApplicationComponent::app
     */
    public function testApp()
    {
        $this->assertInstanceOf('\lib\core\Application',$this->object->app());
        $this->assertInstanceOf('\test\TestApplication',$this->object->app());        
    }
}
