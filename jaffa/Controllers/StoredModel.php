<?php

namespace Jaffa\Controllers;

use PDO;
use Jaffa\Helpers\StringHelper;

class StoredModel extends Model
{
    /** @var PDO $database */
    private $database;

    /** @var string $table */
    private $table;

    public function __construct()
    {
        parent::__construct();

        // $this->database = new PDO('mysql:dbname=test;host=127.0.0.1', 'root', null);
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

    /**
     * @todo Make function to return models variables defined inside fillable array
     */
    private function getFillableData() : array
    {

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