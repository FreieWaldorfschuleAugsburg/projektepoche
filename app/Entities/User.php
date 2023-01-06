<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'password' => null,
        'group_id' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'password' => 'string',
        'group_id' => 'integer'
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
     * @return string
     */
    public function getShortName(): string
    {
        $firstInitial = substr($this->getName(), 0, 1);
        return $firstInitial . '. ' . explode(' ', $this->getName())[1];
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->attributes['password'];
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->attributes['group_id'];
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return getGroupById($this->getGroupId());
    }

    /**
     * @return bool
     */
    public function hasVoted(): bool
    {
        return hasVoted($this->getId());
    }
}