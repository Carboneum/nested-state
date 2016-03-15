<?php

namespace Carboneum\NestedState\Interfaces;

use Carboneum\NestedState\Exception\ParameterMissingException;

/**
 * Interface WritableStateInterface
 * @package Carboneum\NestedState
 */
interface WritableStateInterface
{
    /**
     * @param string $key
     * @param string|int|bool $value
     *
     * @throws ParameterMissingException
     *
     * @return $this
     */
    public function setParameter($key, $value);
}
