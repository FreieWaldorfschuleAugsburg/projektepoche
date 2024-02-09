<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Day extends Entity
{
    protected $attributes = [
        'id' => null,
        'date' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'date' => 'string',
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
}