<?php
/**
 * Created by PhpStorm.
 * User: junhai
 * Date: 2018/10/11
 * Time: 20:09
 */

namespace JunhaiServer\Workflow;


class TransitionTest extends \PHPUnit_Framework_TestCase
{

    public function test__construct()
    {
        $transition = new Transition('name', 'a', 'b');
        $this->assertSame('name', $transition->getName());
        $this->assertSame(array('a'), $transition->getFroms());
        $this->assertSame(array('b'), $transition->getTos());
    }
}
