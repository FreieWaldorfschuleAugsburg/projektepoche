<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Group extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'admin' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'admin' => 'boolean'
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->attributes['admin'];
    }
}