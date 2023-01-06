<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProjectLeaderMapping extends Entity
{
    protected $attributes = [
        'id' => null,
        'user_id' => null,
        'project_id' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'project_id' => 'integer'
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

    /**
     * @return User
     */
    public function getUser(): User
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
}