<?php


namespace Ardenexal\FormHandler\Exception;


use Exception;
use Throwable;

class FormHandlerNotValidException extends Exception
{
    /**
     * FormHandlerNotValidException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = 'Class must implement FormHandler Interface', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}