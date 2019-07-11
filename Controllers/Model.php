<?php

namespace Controllers;

class Model
{
    const ARG_OBJECT_DATA = 0;

    const SET = 'set';
    const GET = 'get';

    public function __construct()
    {
        $args = func_get_args();

        if (isset($args[self::ARG_OBJECT_DATA]) && !is_array($args[self::ARG_OBJECT_DATA])) {
            throw new \Exception(sprintf(
                'Model error: Expected array of object parameters got %s',
                gettype($args[self::ARG_OBJECT_DATA])
            ));
        }
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }
}