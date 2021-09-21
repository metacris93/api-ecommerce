<?php

namespace App\Exceptions;

use Exception;

class InvalidScoreException extends Exception
{
    private $from;
    private $to;

    public function __constructor($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function From()
    {
        return $this->from;
    }
    public function To()
    {
        return $this->to;
    }
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        return true;
    }
    public function render($request)
    {
        if ($request->expectsJson())
        {
            return response()->json([
                'status' => 'Error',
                'message' => "Score invalido, el valor debe estar dentro de {$this->From()} {$this->To()}",
                'data' => []
            ], 500);
        }
        return response('Score Error', 500);
    }
}
