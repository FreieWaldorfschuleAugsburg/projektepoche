<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Group extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'voting' => null,
        'admin' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'voting' => 'boolean',
        'admin' => 'boolean'
    ];

    /**
     * @return ?int
     */
    public function getId(): ?int
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
    public function mayVote(): bool
    {
        return $this->attributes['vote'];
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->attributes['admin'];
    }
}