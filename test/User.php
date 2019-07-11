<?php

namespace test;

use \Controllers\Model;

class User extends Model
{
    protected $name;
    protected $surname;
    protected $age;

    protected $fillable = ['name', 'surname', 'age'];
    protected $hidden = ['age'];
}