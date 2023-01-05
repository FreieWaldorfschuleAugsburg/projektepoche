<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity

{
    protected int $id;
    protected string $name;
    protected string $password;
    protected int $group_id;
}