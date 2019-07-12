<?php

namespace Jaffa\Services;

use PDO;

final class DatabaseService
{
    private $provider;

    private $host;

    private $port;

    private $database;

    private $user;

    private $password;

    private $connection;

    public function __construct($provider, $host, $port, $database, $user, $password)
    {
        $this->provider = $provider;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
    }

    public function connect()
    {
        $this->connection = new PDO(
            sprintf('%s:dbname=%s;host=%s:%s', $this->provider, $this->database, $this->host, $this->port),
            $this->user,
            $this->password
        );
    }

    public function disconnect()
    {
        $this->connection = null;
    }
}