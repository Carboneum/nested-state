<?php

namespace Carboneum\NestedState;

use Carboneum\NestedState\Exception\ParameterMissingException;
use Carboneum\NestedState\Interfaces\StateInterface;

/**
 * Class State
 * @package Carboneum\NestedState
 */
class State implements StateInterface
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $parametersWeight = [];

    /**
     * @param array $parameters All state parameters must be specified, if some of them could not be evaluated yet
     * they should be passed with null value for further assignment
     */
    public function __construct(array $parameters)
    {
        $this->initParameters($parameters);
    }

    /**
     * @param array $parameters
     * @return $this
     */
    protected function initParameters(array $parameters)
    {
        $this->parameters = $parameters;
        $parametersPositions = array_flip(array_keys(array_reverse($parameters)));

        foreach ($parametersPositions as $key => $position) {
            $this->parametersWeight[$key] = 1 << $position;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setParameter($key, $value)
    {
        if (!$this->hasParameter($key)) {
            throw new ParameterMissingException($key);
        }

        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParameter($key)
    {
        if (!$this->hasParameter($key)) {
            throw new ParameterMissingException($key);
        }

        return $this->parameters[$key];
    }

    /**
     * @inheritdoc
     */
    public function getParameters(array $keys)
    {
        $missingKeys = array_diff($keys, array_keys($this->parameters));

        if ($missingKeys) {
            throw new ParameterMissingException(implode($missingKeys));
        }

        return array_intersect_key($this->parameters, array_flip($keys));
    }

    /**
     * @inheritdoc
     */
    public function getAllParameters()
    {
        return $this->parameters;
    }

    /**
     * @inheritdoc
     */
    public function hasParameter($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * @inheritdoc
     */
    public function matches(array $parameters)
    {
        return $parameters === $this->getParameters(array_keys($parameters));
    }

    /**
     * @inheritdoc
     */
    public function getMatchWeight(array $parameters)
    {
        if (!$this->matches($parameters)) {
            return false;
        }

        return array_sum(array_intersect_key($this->parametersWeight, $parameters));
    }

    /**
     * @param string $string
     * @return array
     */
    public static function getParametersByString($string)
    {
        $parameters = [];

        if (empty($string)) {
            return [];
        }

        parse_str($string, $parameters);

        return $parameters;
    }
}
