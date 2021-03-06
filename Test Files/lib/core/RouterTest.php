<?php

namespace lib\core;

class TestRouter extends Router
{

    public function getRouteNumber()
    {
        return count($this->routes);
    }

}

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-26 at 06:47:34.
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Router
     */
    protected $object;

    /**
     * @var TestRouter 
     */
    protected $extendedObject;

    /**
     * @var Route  
     */
    protected $realRoute;

    /**
     * @var Route  
     */
    protected $route1;

    /**
     * @var Route  
     */
    protected $route1bis;

    /**
     * @var Route  
     */
    protected $routeWithVars;

    /**
     * @var Route  
     */
    protected $route3;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object         = new Router;
        $this->extendedObject = new TestRouter;

        $this->realRoute = new Route('/news-(.+)-([0-9]+)\.html', 'news', 'view', array('nom', 'id'));

        $this->route1 = new Route('a', 'b', 'c', array());
        $this->route1bis = new Route('a', 'b', 'c', array());
        $this->routeWithVars = new Route('a-([0-9]+)-([a-z]+)', 'b', 'c', array('a', 'b'));
        $this->route3 = new Route('z', 'y', 'x', array('a', 'b'));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    // <editor-fold defaultstate="collapsed" desc="addRoute">

    /**
     * @covers lib\core\Router::addRoute
     */
    public function testAddRoute_AddOneRoute()
    {
        $this->assertEquals(0, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoute($this->realRoute);
        $this->assertEquals(1, $this->extendedObject->getRouteNumber());
    }

    /**
     * @covers lib\core\Router::addRoute
     */
    public function testAddRoute_AddSameRouteInstanceTwoTimes()
    {
        $this->assertEquals(0, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoute($this->realRoute);
        $this->assertEquals(1, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoute($this->realRoute);
        $this->assertEquals(1, $this->extendedObject->getRouteNumber());
    }

    /**
     * @covers lib\core\Router::addRoute
     */
    public function testAddRoute_AddSameRouteTwoTimes_TwoInstances()
    {
        $this->assertEquals(0, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoute($this->route1);
        $this->assertEquals(1, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoute($this->route1bis);
        $this->assertEquals(1, $this->extendedObject->getRouteNumber());
    }

    /**
     * @covers lib\core\Router::addRoute
     */
    public function testAddRoute_AddTwoDifferentRoutes()
    {
        $this->assertEquals(0, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoute($this->route1);
        $this->assertEquals(1, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoute($this->routeWithVars);
        $this->assertEquals(2, $this->extendedObject->getRouteNumber());
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="addRoutes">

    /**
     * @covers lib\core\Router::addRoutes
     */
    public function testAddRoutes_ArrayOfDifferentRoutes()
    {
        $routes = array($this->route1, $this->routeWithVars, $this->route3);

        $this->assertEquals(0, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoutes($routes);
        $this->assertEquals(3, $this->extendedObject->getRouteNumber());
    }

    /**
     * @covers lib\core\Router::addRoutes
     */
    public function testAddRoutes_ArrayOfSameRoute()
    {
        $routes = array($this->route1, $this->route1bis, $this->route3);

        $this->assertEquals(0, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoutes($routes);
        $this->assertEquals(2, $this->extendedObject->getRouteNumber());
    }

    /**
     * @covers lib\core\Router::addRoutes
     */
    public function testAddRoutes_SeveralArrays()
    {
        $routes1 = array($this->route1, $this->route1bis, $this->route3);
        $routes2 = array($this->routeWithVars, $this->routeWithVars);
        $routes3 = array($this->route1, $this->routeWithVars, $this->route3, $this->realRoute);

        $this->assertEquals(0, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoutes($routes1);
        $this->assertEquals(2, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoutes($routes2);
        $this->assertEquals(3, $this->extendedObject->getRouteNumber());
        $this->extendedObject->addRoutes($routes3);
        $this->assertEquals(4, $this->extendedObject->getRouteNumber());
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="getRoute">

    /**
     * @covers lib\core\Router::getRoute
     * @expectedException RuntimeException
     * @expectedExceptionCode \lib\core\Router::NO_ROUTE
     */
    public function testGetRoute_NoRoute()
    {
        $this->object->getRoute('a');
    }

    /**
     * @covers lib\core\Router::getRoute
     */
    public function testGetRoute_RouteWithNoVars()
    {
        $this->object->addRoute($this->route1);

        $route = $this->object->getRoute('a');
        $this->assertInstanceOf('\lib\core\Route', $route);
        $this->assertEquals($this->route1, $route);
    }
    
    /**
     * @covers lib\core\Router::getRoute
     */
    public function testGetRoute_RouteWithVars()
    {
        $this->object->addRoute($this->routeWithVars);

        $route = $this->object->getRoute('a-987-bepo');
        $this->assertInstanceOf('\lib\core\Route', $route);
        
        $expectedRoute = new Route('a-([0-9]+)-([a-z]+)',
                $this->routeWithVars->module(),
                $this->routeWithVars->action(),
                $this->routeWithVars->varsNames());
        $expectedRoute->setVars(array('a'=>'987', 'b'=>'bepo'));
        $this->assertEquals($expectedRoute, $route);
    }

    // </editor-fold>
}
