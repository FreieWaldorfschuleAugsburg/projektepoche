<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity

{
    public int $id;
    public string $name;
    public string $password;
    public int $group_id;
}