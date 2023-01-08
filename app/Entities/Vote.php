<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Vote extends Entity
{
    protected $attributes = [
        'id' => null,
        'user_id' => null,
        'vote_id' => null,
        'project_id' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'vote_id' => 'integer',
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

    public function setUserId(int $userId)
    {
        $this->attributes['user_id'] = $userId;
    }

    /**
     * @return int
     */
    public function getVoteId(): int
    {
        return $this->attributes['vote_id'];
    }

    public function setVoteId(int $voteId)
    {
        $this->attributes['vote_id'] = $voteId;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->attributes['project_id'];
    }

    public function setProjectId(int $projectId)
    {
        $this->attributes['project_id'] = $projectId;
    }
}