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
        'start_day' => null,
        'end_day' => null
    ];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'start_time' => 'string',
        'end_time' => 'string',
        'start_day' => 'integer',
        'end_day' => 'integer'
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

    public function getStartDayId(): int
    {
        return $this->attributes['start_day'];
    }

    public function setStartDayId(int $startDayId): void
    {
        $this->attributes['start_day'] = $startDayId;
    }

    public function getEndDayId(): int
    {
        return $this->attributes['end_day'];
    }

    public function setEndDayId(int $endDayId): void
    {
        $this->attributes['end_day'] = $endDayId;
    }
}