<?php

namespace Jaffa\Controllers;

use Exception;

class Model
{
    const ARG_OBJECT_DATA = 0;

    const SET = 'set';
    const GET = 'get';

    protected $fillable = [];
    protected $hidden = [];
    private $primaryHidden = ['fillable', 'hidden', 'primaryHidden'];

    /**
     * Model constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $args = func_get_args();

        if (isset($args[self::ARG_OBJECT_DATA])) {
            if (!is_array($args[self::ARG_OBJECT_DATA])) {
                throw new Exception(sprintf(
                    'Model error: Expected array of object parameters got %s',
                    gettype($args[self::ARG_OBJECT_DATA])
                ));
            } else {
                $fillableValues = $this->getOnlyFillable($args[self::ARG_OBJECT_DATA]);
                foreach ($fillableValues as $key => $value) {
                    $method = self::SET . ucfirst($key);
                    $this->$method($value);
                }
            }
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        $methodData = $this->destructMethodName($name);

        if (count($methodData) == 2) {
            $var = lcfirst($methodData[1]);
            switch($methodData[0]) {
                case self::SET:
                    $this->$var = $arguments[0];
                    return $this;
                case self::GET:
                    return $this->$var;
                default:
                    throw new Exception(sprintf('Model error: Undefined method %s', $name));
            }
        }

        return null;
    }

    public function getData()
    {
        $hidden = array_merge($this->hidden, $this->primaryHidden);

        return array_filter(get_object_vars($this), function ($key) use ($hidden) {
            return !in_array($key, $hidden);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function destructMethodName($name)
    {
        preg_match('/([a-z]{1,})([A-Z][a-z,A-Z]{1,})/', $name, $destructed);
        return array_slice($destructed, 1);
    }

    private function getOnlyFillable($values)
    {
        return array_filter($values, function ($key) {
            return in_array($key, $this->fillable);
        }, ARRAY_FILTER_USE_KEY);
    }
}