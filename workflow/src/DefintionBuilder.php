<?php
/**
 * Created by PhpStorm.
 * User: junhai
 * Date: 2018/10/11
 * Time: 16:39
 */

namespace JunhaiServer\Workflow;

use JunhaiServer\Workflow\Definition;

class DefintionBuilder
{
    //工作流的状态数组
    private $places = [];
    //所有过渡行为
    private $transitions = [];
    //起始状态
    private $initialPlace;

    public function __construct(array $places = [], array $transitions = [])
    {
        $this->addPlaces($places);
        $this->addTransitions($transitions);
    }

    /**
     * @return Definition
     * @throws Exceptions\NoFromException
     * @throws Exceptions\NoPlaceException
     * @throws Exceptions\NoToException
     */
    public function build()
    {
        return new Definition($this->places, $this->transitions, $this->initialPlace);
    }

    public function clear()
    {
        $this->places = array();
        $this->transitions = array();
        $this->initialPlace = null;
        return $this;
    }

    public function setInitialPlace($place)
    {
        $this->initialPlace = $place;
        return $this;
    }

    /**
     * @param $place
     * @return $this
     */
    public function addPlace($place)
    {
        if (!$this->places) {
            $this->initialPlace = $place;
        }
        $this->places[$place] = $place;
        return $this;
    }

    /**
     * @param array $places
     * @return $this
     */
    public function addPlaces(array $places)
    {
        foreach ($places as $place) {
            $this->addPlace($place);
        }
        return $this;
    }
    /**
     * @param Transition[] $transitions
     *
     * @return $this
     */
    public function addTransitions(array $transitions)
    {
        foreach ($transitions as $transition) {
            $this->addTransition($transition);
        }
        return $this;
    }
    /**
     * @return $this
     */
    public function addTransition(Transition $transition)
    {
        $this->transitions[] = $transition;
        return $this;
    }



}