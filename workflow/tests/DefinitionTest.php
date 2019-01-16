<?php
/**
 * Created by PhpStorm.
 * User: junhai
 * Date: 2018/10/11
 * Time: 20:11
 */

namespace JunhaiServer\Workflow;

use JunhaiServer\Workflow\Definition;


class DefinitionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @throws Exceptions\NoFromException
     * @throws Exceptions\NoPlaceException
     * @throws Exceptions\NoToException
     */
    public function testAddPlaces()
    {
        $places = range('a', 'e');
        $definition = new Definition($places, array());
        $this->assertCount(5, $definition->getPlaces());

    }

    /**
     * @throws Exceptions\NoFromException
     * @throws Exceptions\NoPlaceException
     * @throws Exceptions\NoToException
     */
    public function testSetInitialPlace()
    {
        $places = range('a', 'e');
        $definition = new Definition($places, array(), $places[3]);
        $this->assertEquals($places[3], $definition->getInitialPlace());
    }
    /**
     * @expectedException \JunhaiServer\Workflow\Exceptions\NoPlaceException
     * @expectedExceptionMessage Place d cannot be the initial place as it does not exist.
     */
    public function testSetInitialPlaceAndPlaceIsNotDefined()
    {
        $definition = new Definition(array(), array(), 'd');
    }

    public function testAddTransition()
    {
        $places = range('1', '2');
        $transition = new Transition('name', $places[0], $places[1]);
        $definition = new Definition($places, array($transition));
        $this->assertCount(1, $definition->getTransitions());
        $this->assertSame($transition, $definition->getTransitions()[0]);
    }

    /**
     * @expectedException \JunhaiServer\Workflow\Exceptions\NoFromException
     * @expectedExceptionMessage Place "3" referenced in transition "name" does not exist.
     */
    public function testAddTransitionAndFromPlaceIsNotDefined()
    {
        $places = range('1', '2');
        new Definition($places, array(new Transition('name', '3', $places[1])));
    }
    /**
     * @expectedException \JunhaiServer\Workflow\Exceptions\NoToException
     * @expectedExceptionMessage Place "3" referenced in transition "name" does not exist.
     */
    public function testAddTransitionAndToPlaceIsNotDefined()
    {
        $places = range('1', '2');
        new Definition($places, array(new Transition('name', $places[0], '3')));
    }




}
