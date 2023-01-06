<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Project extends Entity
{
    protected $attributes = [
        'id' => null,
        'slot_id' => null,
        'name' => null,
        'description' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'slot_id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @return int
     */
    public function getSlotId(): int
    {
        return $this->attributes['slot_id'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->attributes['description'];
    }
}