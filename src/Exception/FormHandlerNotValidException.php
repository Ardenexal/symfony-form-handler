<?php


namespace FormHandler\Exception;


use Exception;
use Throwable;

class FormHandlerNotValidException extends Exception
{
    public function __construct($message = 'Class must implement FormHandler Interface', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}