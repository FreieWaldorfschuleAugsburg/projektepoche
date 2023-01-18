<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Project extends Entity
{
    protected $attributes = [
        'id' => null,
        'slot_id' => null,
        'name' => null,
        'max_members' => null,
        'room' => null,
        'description' => null,
        'selectable' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'slot_id' => 'integer',
        'name' => 'string',
        'max_members' => 'integer',
        'room' => 'string',
        'description' => 'string',
        'selectable' => 'boolean'
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
     * @return int
     */
    public function getMaxMembers(): int
    {
        return $this->attributes['max_members'];
    }

    public function setMaxMembers(int $maxMembers): void
    {
        $this->attributes['max_members'] = $maxMembers;
    }

    /**
     * @return string
     */
    public function getRoom(): string
    {
        return $this->attributes['room'];
    }

    public function setRoom(string $room): void
    {
        $this->attributes['room'] = $room;
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
     * @return bool
     */
    public function isSelectable(): bool
    {
        return $this->attributes['selectable'];
    }

    public function setSelectable(bool $selectable): void
    {
        $this->attributes['selectable'] = $selectable;
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

    public function hasConflict(): bool
    {
        return count($this->getMembers()) > $this->getMaxMembers();
    }
}