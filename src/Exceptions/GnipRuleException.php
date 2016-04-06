<?php

namespace Gnip\Exceptions;


/**
 * Class GnipRuleException
 * @package GnipRules
 */
class GnipRuleException extends \Exception implements \JsonSerializable
{
    const DEFAULT_MESSAGE = 'An error has occurred with the GnipRule package';
    const DEFAULT_CODE = 500;

    /**
     * @param null       $message
     * @param null       $code
     * @param \Exception $previous
     */
    function __construct($message = null, $code = null, \Exception $previous = null)
    {
        parent::__construct($message ?? self::DEFAULT_MESSAGE, $code ?? self::DEFAULT_CODE, $previous);
    }

    /**
     *
     */
    function jsonSerialize()
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'stack_trace' => $this->getTrace()
        ];
    }

}