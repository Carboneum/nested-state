<?php


namespace Carboneum\NestedState\Exception;

use Exception;
use Quartz\Framework\Exception\RuntimeException;

class ParameterMissingException extends \Exception
{
    /**
     * @var string
     */
    protected $parameter;

    /**
     * @param string $parameter
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($parameter, $message = "Key %s is not defined", $code = 0, Exception $previous = null)
    {
        $this->parameter = $parameter;
        parent::__construct(sprintf($message, $parameter), $code, $previous);
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getParameter()
    {
        return $this->parameter;
    }
}
