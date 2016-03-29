<?php

namespace Carboneum\NestedState\Interfaces;

use Carboneum\NestedState\Exception\ParameterMissingException;

/**
 * Interface ReadableStateInterface
 * @package Carboneum\NestedState
 */
interface ReadableStateInterface
{
    /**
     * @param string $key
     * @return string|int|bool
     * @throws ParameterMissingException
     */
    public function getParameter($key);

    /**
     * @param array $keys
     * @return array
     * @throws ParameterMissingException
     */
    public function getParameters(array $keys);

    /**
     * @return array
     */
    public function getAllParameters();

    /**
     * @param string $key
     * @return bool
     */
    public function hasParameter($key);

    /**
     * @param array $parameters
     * @return bool
     */
    public function matches(array $parameters);

    /**
     * Returns weight of parameters match – the higher match position is – the higher number returns.
     * If parameters don't match – returns false.
     *
     * @param array $parameters
     * @return int|bool
     */
    public function getMatchWeight(array $parameters);
}
