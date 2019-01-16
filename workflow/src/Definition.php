<?php
/**
 * Created by PhpStorm.
 * User: junhai
 * Date: 2018/10/11
 * Time: 15:57
 */

namespace JunhaiServer\Workflow;

use JunhaiServer\Workflow\Exceptions\NoFromException;
use JunhaiServer\Workflow\Exceptions\NoPlaceException;
use JunhaiServer\Workflow\Exceptions\NoToException;

class Definition
{
    //工作流的状态数组
    private $places = [];
    //所有过渡行为
    private $transitions = [];
    //起始状态
    private $initialPlace;

    /**
     * Definition constructor.
     * @param array $places
     * @param array $transitions
     * @param string|null $initialPlace
     * @throws NoFromException
     * @throws NoPlaceException
     * @throws NoToException
     */
    public function __construct(array $places, array $transitions, string $initialPlace = null)
    {
        foreach ($places as $place) {
            $this->addPlace($place);
        }

        foreach ($transitions as $transition) {
            $this->addTransition($transition);
        }

        $this->setInitialPlace($initialPlace);
    }

    /**
     * @return string|null
     */
    public function getInitialPlace()
    {
        return $this->initialPlace;
    }
    /**
     * @return string[]
     */
    public function getPlaces(): array
    {
        return $this->places;
    }
    /**
     * @return Transition[]
     */
    public function getTransitions(): array
    {
        return $this->transitions;
    }

    /**
     * 设置起始位置
     *
     * @param string|null $place
     * @throws NoPlaceException
     */
    private function setInitialPlace(string $place = null)
    {
        if (null === $place) {
            return;
        }
        if (!isset($this->places[$place])) {
            throw new NoPlaceException(
                'Place '. $place .' cannot be the initial place as it does not exist.',
                1000);
        }

        $this->initialPlace = $place;
    }

    /**
     * @param string $place
     */
    private function addPlace(string $place)
    {
        if (!\count($place)) {
            $this->initialPlace = $place;
        }

        $this->places[$place] = $place;
    }

    /**
     * @param Transition $transition
     * @throws NoFromException
     * @throws NoToException
     */
    private function addTransition(Transition $transition)
    {
        $name = $transition->getName();

        foreach ($transition->getFroms() as $from) {
            if (!isset($this->places[$from])) {
                throw new NoFromException(
                    sprintf('Place "%s" referenced in transition "%s" does not exist.', $from, $name),
                    10000
                );
            }
        }
        foreach ($transition->getTos() as $to) {
            if (!isset($this->places[$to])) {
                throw new NoToException(
                    sprintf('Place "%s" referenced in transition "%s" does not exist.', $to, $name),
                    10000
                );
            }
        }
        $this->transitions[] = $transition;
    }




}