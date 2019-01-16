<?php

namespace JunhaiServer\Workflow;

use JunhaiServer\Workflow\DefintionBuilder;
use JunhaiServer\Workflow\Exceptions\ErrorTransitionException;
use JunhaiServer\Workflow\Transition;

class Workflow
{
    private $definitionBuilder;

    private $defintion;

    private $state;
    /**
     * Workflow constructor.
     * @param array $places
     * @param array $transitions
     * @throws Exceptions\NoFromException
     * @throws Exceptions\NoPlaceException
     * @throws Exceptions\NoToException
     */
    public function __construct(array $places, array $transitions, string $state)
    {
        $this->definitionBuilder = new DefintionBuilder();
        $this->definitionBuilder->addPlaces($places);
        $this->addTransition($transitions);
        $this->defintion = $this->definitionBuilder->build();

        $this->state = $state;

    }

    public function can($subject,$transitionName)
    {
        $transitions = $this->defintion->getTransitions();

        foreach ($transitions as $transition) {
            if ($transition->getName() !== $transitionName) {
                continue;
            }

            if (in_array($subject->{$this->state},$transition->getFroms())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $subject
     * @param $transitionName
     * @return mixed
     * @throws ErrorTransitionException
     */
    public function apply($subject,$transitionName)
    {
        $transitions = $this->defintion->getTransitions();

        $applied = false;

        foreach ($transitions as $transition) {
            if ($transition->getName() !== $transitionName) {
                continue;
            }

            if (in_array($subject->{$this->state},$transition->getFroms())) {
                $subject = $this->transition($subject,$transition);
                $applied = true;

                return $subject;
            }
        }

        if (!$applied) {
            throw new ErrorTransitionException(
                sprintf('TransitionName "%s" referenced in transition  from "%s" to error.', $transitionName, $subject->{$this->state}),
                10000
            );
        }

        return $subject;
    }

    private function transition($subject,Transition $transition)
    {
        $to = implode("",$transition->getTos());
        $subject->{$this->state} = $to;

        return $subject;
    }

    private function addTransition($transitions)
    {
        foreach ($transitions as $key=>$value) {
            $this->definitionBuilder->addTransition(new Transition($key,$value['from'],$value['to']));
        }

        return $this;
    }
}