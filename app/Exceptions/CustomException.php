<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class CustomException extends Exception
{
    protected $message;

    public function __construct($message = '', $code = 0, ?Throwable $previous = null)
    {
        $this->message = $message;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->view('errors.custom', ['exception' => $this], 500);
    }
}
