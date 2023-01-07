<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Slot extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'start_time' => null,
        'end_time' => null,
    ];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'start_time' => 'string',
        'end_time' => 'string'
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

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    /**
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->attributes['start_time'];
    }

    public function setStartTime(string $startTime): void
    {
        $this->attributes['start_time'] = $startTime;
    }

    /**
     * @return string
     */
    public function getEndTime(): string
    {
        return $this->attributes['end_time'];
    }

    public function setEndTime(string $endTime): void
    {
        $this->attributes['end_time'] = $endTime;
    }
}