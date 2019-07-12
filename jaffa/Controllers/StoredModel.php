<?php

namespace Jaffa\Controllers;

use DateTime;
use Jaffa\Helpers\StringHelper;

class StoredModel extends Model
{
    /** @var string $table */
    private $table;


    public function __construct()
    {
        parent::__construct();

        $this->table = $this->getTableName();
    }

    public function __call($name, $arguments)
    {
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
        $data = $this->getData();

        $set = array_map(function ($key, $value) {
            $column = StringHelper::toUnderscore($key);
            return sprintf('%s = %s', $column, $this->typeToString($value));
        }, $data);
        $values = implode(', ', $set);
        $update = sprintf('UPDATE %s SET %s WHERE id = %s', $this->table, $values, $this->getId());

        echo $update;

    }

    /**
     * @todo Make function to return models variables defined inside fillable array
     */
    private function getFillableData() : array
    {

    }

    private function typeToString($value)
    {
        switch (gettype($value)) {
            case 'string':
                return sprintf('\'%s\'', $value);
            case 'integer':
            case 'float':
                return sprintf('%s', $value);
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
        $modelName = strtolower(array_pop(explode('\\', get_class($this))));

        // Pluralise model name
        // Reference https://www.grammarly.com/blog/plural-nouns/
        // Todo: Make string manipulation tool

        return StringHelper::pluralize($modelName);
    }
}