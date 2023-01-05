<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Group extends Entity
{
    public int $id;
    public string $name;
    public bool $admin;
}