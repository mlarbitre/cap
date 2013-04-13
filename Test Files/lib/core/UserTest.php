<?php

namespace lib\core;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-31 at 15:31:04.
 */
class UserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var User
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $app          = new \test\TestApplication();
        $this->object = new User($app);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers \lib\core\User::__construct
     */
    public function testConstruct()
    {
        unset($_SESSION[User::USER_INDEX]);
        $app  = new \test\TestApplication();
        $this->assertArrayNotHasKey(User::USER_INDEX, $_SESSION);
        $test = new User($app);
        $this->assertArrayHasKey(User::USER_INDEX, $_SESSION);
    }

    // <editor-fold defaultstate="collapsed" desc="isAuthenticated">

    /**
     * @covers \lib\core\User::isAuthenticated
     */
    public function testIsAuthenticated_SessionUndefined()
    {
        $this->assertFalse($this->object->isAuthenticated());
    }

    /**
     * @covers \lib\core\User::isAuthenticated
     */
    public function testIsAuthenticated_SessionTrueValue()
    {
        $_SESSION[User::USER_INDEX][User::AUTH] = true;
        $this->assertEquals($_SESSION[User::USER_INDEX][User::AUTH],
                            $this->object->isAuthenticated());
    }

    /**
     * @covers \lib\core\User::isAuthenticated
     */
    public function testIsAuthenticated_SessionFalseValue()
    {
        $_SESSION[User::USER_INDEX][User::AUTH] = false;
        $this->assertEquals($_SESSION[User::USER_INDEX][User::AUTH],
                            $this->object->isAuthenticated());
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="setAuthenticated">

    /**
     * @covers \lib\core\User::setAuthenticated
     */
    public function testSetAuthenticated_FalseArgument()
    {
        $this->object->setAuthenticated(false);
        $this->assertFalse($_SESSION[User::USER_INDEX][User::AUTH]);
    }

    /**
     * @covers \lib\core\User::setAuthenticated
     */
    public function testSetAuthenticated_NoArgumentLikeTrueArgument()
    {
        $this->object->setAuthenticated();
        $this->assertTrue($_SESSION[User::USER_INDEX][User::AUTH]);
    }

    /**
     * @covers \lib\core\User::setAuthenticated
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode \lib\core\User::INVALID_AUTH_ARGUMENT
     */
    public function testSetAuthenticated_IntArgument()
    {
        $this->object->setAuthenticated(2);
    }

    /**
     * @covers \lib\core\User::setAuthenticated
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode \lib\core\User::INVALID_AUTH_ARGUMENT
     */
    public function testSetAuthenticated_EmptyArgument()
    {
        $this->object->setAuthenticated('');
    }

    // </editor-fold>
}
