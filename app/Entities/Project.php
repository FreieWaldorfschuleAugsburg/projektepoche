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
     * @return ?int
     */
    public function getId(): ?int
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

    public function setSlotId(int $slotId): void
    {
        $this->attributes['slot_id'] = $slotId;
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
    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    /**
     * @return User[]
     */
    public function getLeaders(): array
    {
        return getProjectLeadersByProjectId($this->getId());
    }

    public function getLeaderShortNameString(): string
    {
        $result = "";
        $leaders = $this->getLeaders();
        $i = 0;
        foreach ($leaders as $leader) {
            $result .= ($i >= 1 ? ", " : "") . $leader->getShortName();
            $i++;
        }
        return $result;
    }

    /**
     * @return User[]
     */
    public function getMembers(): array
    {
        return getProjectMembersByProjectId($this->getId());
    }

    public function getMemberNameString(): string
    {
        $result = "";
        $members = $this->getMembers();
        $i = 0;
        foreach ($members as $member) {
            $result .= ($i >= 1 ? ", " : "") . $member->getName();
            $i++;
        }
        return $result;
    }
}