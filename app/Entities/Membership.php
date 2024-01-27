<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Membership extends Entity
{
    protected $attributes = [
        'id' => null,
        'user_id' => null,
        'project_id' => null,
        'leader' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'project_id' => 'integer',
        'leader' => 'bool'
    ];

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->attributes['id'];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    /**
     * @return ?User
     */
    public function getUser(): ?User
    {
        return getUserById($this->getUserId());
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->attributes['project_id'];
    }

    public function setProjectId(int $projectId): void
    {
        $this->attributes['project_id'] = $projectId;
    }

    /**
     * @return ?Project
     */
    public function getProject(): ?Project
    {
        return getProjectById($this->getProjectId());
    }

    public function isLeader(): bool
    {
        return $this->attributes['leader'];
    }

    public function setLeader(bool $leader)
    {
        $this->attributes['leader'] = $leader;
    }
}