<?php


namespace Carboneum\NestedState;

use Carboneum\NestedState\Exception\ParameterMissingException;

/**
 * Class State
 * @package Carboneum\NestedState
 */
class State
{
    /** @var array */
    protected $parameters = [];
    /** @var array */
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
    public function initParameters(array $parameters)
    {
        $this->parameters = $parameters;
        $parametersPositions = array_flip(array_keys(array_reverse($parameters)));

        foreach ($parametersPositions as $key => $position) {
            $this->parametersWeight[$key] = 1 << $position;
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string|int|bool $value
     * @return $this
     * @throws ParameterMissingException
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
     * @param string $key
     * @return string|int|bool
     * @throws ParameterMissingException
     */
    public function getParameter($key)
    {
        if (!$this->hasParameter($key)) {
            throw new ParameterMissingException($key);
        }

        return $this->parameters[$key];
    }

    /**
     * @param array $keys
     * @return array
     * @throws ParameterMissingException
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
     * @return string
     */
    public function getAllParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasParameter($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * @param array $parameters
     * @return bool
     */
    public function matches(array $parameters)
    {
        return $parameters === $this->getParameters(array_keys($parameters));
    }

    /**
     * Returns weight of parameters match – the higher match position is – the higher number returns.
     * If parameters don't match – returns false.
     *
     * @param array $parameters
     * @return int|bool
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
