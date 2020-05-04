<?php
declare(strict_types = 1);

namespace ORMY\Connector\Exceptions;

use Throwable;

/**
 * Connector error
 */
class ConnectionException extends \Exception
{
    /**
     * Конструктор.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
