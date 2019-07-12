<?php

use App\Models\User;

require_once __DIR__ . '/bootstrap.php';

$user = new User();

$user->setName('John')
    ->setSurname('Doe')
    ->setAge(42)
    ->save();

print_r($user->getData());