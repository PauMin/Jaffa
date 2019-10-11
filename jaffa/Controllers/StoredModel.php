<?php

namespace Jaffa\Controllers;

use DateTime;
use Jaffa\Helpers\StringHelper;

class StoredModel extends Model
{
    /** @var string $table */
    private $table;

    /** @var array $affected */
    private $affected;

    public function __construct()
    {
        parent::__construct();

        $this->table = $this->getTableName();
    }

    public function __call($name, $arguments)
    {
        $methodData = $this->destructMethodName($name);
        if ($methodData[0] === Model::SET) {
            $this->setAffected($methodData[1], $arguments[0]);
        }
        return parent::__call($name, $arguments);
    }

    public function save()
    {
        // Get models data
        $data = $this->getFillableData();

        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_values($data));
        $insert = sprintf('INSERT INTO %s (%s) VALUE (%s)', $this->table, $columns, $values);

        echo $insert;

        // Add data to table if there is no such
    }

    public function update()
    {
        // Get models data
        $data = $this->affected;

        array_walk($data, function (&$value, $key) {
            $column = StringHelper::toUnderscore($key);
            $value = sprintf('%s = %s', $column, $this->typeToString($value));
        });

        $values = implode(', ', $data);
        $update = sprintf('UPDATE %s SET %s WHERE id = %s', $this->table, $values, $this->getId());

        echo $update;

    }

    public static function find($id)
    {
        $class = get_called_class();
        $find = sprintf('SELECT * FROM %s WHERE id = %s', (new $class)->getTableName(), $id);
        $model = new $class;

        echo $find;

        return $model;
    }

    /**
     * @todo Make function to return models variables defined inside fillable array
     */
    private function getFillableData() : array
    {
        return $this->fillable;
    }

    private function typeToString($value)
    {
        switch (gettype($value)) {
            case 'string':
                return sprintf('\'%s\'', $value);
            case 'integer':
            case 'float':
                return sprintf('%d', $value);
            case 'boolean':
                $boolean = $value ? 'true' : 'false';
                return sprintf('%s', $boolean);

        }

        if ($value instanceof DateTime) {
            return sprintf('%s', $value->format('Y-m-d H:i:s'));
        }

        return $value;
    }

    private function getTableName()
    {
        $className = explode('\\', get_class($this));
        $modelName = strtolower(array_pop($className));

        // Pluralise model name
        // Reference https://www.grammarly.com/blog/plural-nouns/
        // Todo: Make string manipulation tool

        return StringHelper::pluralize($modelName);
    }

    private function setAffected($parameter, $argument)
    {
        $this->affected[$parameter] = $argument;
    }
}