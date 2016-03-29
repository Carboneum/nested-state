<?php

namespace Carboneum\NestedState;

use Carboneum\NestedState\Interfaces\ReadableStateInterface;

/**
 * Class ImmutableState
 * @package Carboneum\NestedState
 */
class ImmutableState implements ReadableStateInterface
{
    /**
     * @var ReadableStateInterface
     */
    protected $state;

    /**
     * ImmutableState constructor.
     * @param ReadableStateInterface $state
     */
    public function __construct(ReadableStateInterface $state)
    {
        $this->state = $state;
    }

    /**
     * @inheritdoc
     */
    public function getParameter($key)
    {
        return $this->state->getParameter($key);
    }

    /**
     * @inheritdoc
     */
    public function getParameters(array $keys)
    {
        return $this->state->getParameters($keys);
    }

    /**
     * @inheritdoc
     */
    public function getAllParameters()
    {
        return $this->state->getAllParameters();
    }

    /**
     * @inheritdoc
     */
    public function hasParameter($key)
    {
        return $this->state->hasParameter($key);
    }

    /**
     * @inheritdoc
     */
    public function matches(array $parameters)
    {
        return $this->state->matches($parameters);
    }

    /**
     * @inheritdoc
     */
    public function getMatchWeight(array $parameters)
    {
        return $this->state->getMatchWeight($parameters);
    }
}
