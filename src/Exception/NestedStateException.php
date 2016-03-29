<?php

namespace Carboneum\NestedState\Exception;

use Carboneum\ContextualException\Exception;

/**
 * Class NestedStateException
 * @package Carboneum\NestedState
 */
abstract class NestedStateException extends Exception
{
    const CODE_PACKAGE_PREFIX = 101000;
    const CODE = 0;

    const MESSAGE = 'NestedState exception. Context: {exception_contexts}';

    const ERROR_CODE_PARAMETER_MISSING = 1;
}
