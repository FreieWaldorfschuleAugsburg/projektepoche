<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Group extends Entity
{
    protected int $id;
    protected string $name;
    protected bool $admin;
}