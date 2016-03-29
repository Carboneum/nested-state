<?php

namespace Carboneum\NestedState\Exception;

use Exception;

/**
 * Class ParameterMissingException
 * @package Carboneum\NestedState
 */
class ParameterMissingException extends NestedStateException
{
    const CODE = self::ERROR_CODE_PARAMETER_MISSING;

    const MESSAGE = "Key {key_name} is not defined";

    const KEY_NAME = 'key_name';

    /**
     * @param string $keyName
     * @param Exception $previous
     */
    public function __construct($keyName, Exception $previous = null)
    {
        $this->setContextValue(self::KEY_NAME, $keyName);
        parent::__construct($previous);
    }
}
