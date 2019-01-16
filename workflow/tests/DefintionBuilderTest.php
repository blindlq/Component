<?php
/**
 * Created by PhpStorm.
 * User: junhai
 * Date: 2018/10/12
 * Time: 10:26
 */

namespace JunhaiServer\Workflow;

use JunhaiServer\Workflow\DefintionBuilder;

class DefintionBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testAddPlace()
    {
        $builder = new DefintionBuilder(array('1'), array());
        $builder->addPlace('2');
        $definition = $builder->build();
        $this->assertCount(2, $definition->getPlaces());
        $this->assertEquals('1', $definition->getPlaces()['1']);
        $this->assertEquals('2', $definition->getPlaces()['2']);
    }

    public function testAddTransition()
    {
        $places = range('1', '2');
        $transition0 = new Transition('name0', $places[0], $places[1]);
        $transition1 = new Transition('name1', $places[0], $places[1]);
        $builder = new DefintionBuilder($places, array($transition0));
        $builder->addTransition($transition1);
        $definition = $builder->build();
        $this->assertCount(2, $definition->getTransitions());
        $this->assertSame($transition0, $definition->getTransitions()[0]);
        $this->assertSame($transition1, $definition->getTransitions()[1]);
    }

    public function testSetInitialPlace()
    {
        $builder = new DefintionBuilder(array('1', '2'));
        $builder->setInitialPlace('2');
        $definition = $builder->build();
        $this->assertEquals('2', $definition->getInitialPlace());
    }
}
