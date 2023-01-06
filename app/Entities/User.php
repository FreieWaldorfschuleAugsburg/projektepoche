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

    public function setPassword(string $password): void
    {
        $this->attributes['password'] = $password;
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->attributes['group_id'];
    }

    public function setGroupId(int $groupId): void
    {
        $this->attributes['group_id'] = $groupId;
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