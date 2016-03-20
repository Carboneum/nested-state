<?php

namespace Carboneum\NestedState\Helper;

/**
 * Class ParameterSerializer
 * @package Carboneum\NestedState
 */
class ParameterSerializer
{
    /**
     * @param string $string
     * @return array
     */
    public function getParametersByString($string)
    {
        $parameters = [];

        if (empty($string)) {
            return [];
        }

        parse_str($string, $parameters);

        return $parameters;
    }
}
