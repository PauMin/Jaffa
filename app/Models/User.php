<?php

namespace App\Models;

use Jaffa\Controllers\StoredModel;

/**
 * @method integer getId()
 * @method string  getName()
 * @method string  getSurname()
 * @method integer getAge()
 * @method User    setName(string $string)
 * @method User    setSurname(string $string)
 * @method User    setAge(int $int)
 */
class User extends StoredModel
{
    /** @var integer */
    protected $id = 2;
    /** @var string */
    protected $name;
    /** @var string */
    protected $surname;
    /** @var integer */
    protected $age;

    /**
     * Values that could be filled with setters
     * @var array
     */
    protected $fillable = ['name', 'surname', 'age'];

    /**
     * Values that would not be returned from getData()
     * @var array
     */
    protected $hidden = ['age'];

    /**
     * Returns full name
     * @return string
     */
    public function getFullName()
    {
        return $this->getName() . ' ' . $this->getSurname();
    }
}