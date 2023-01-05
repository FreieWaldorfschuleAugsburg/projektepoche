<?php

namespace App\Entities;
class User extends \CodeIgniter\Entity\Entity

{
    protected int $id;
    protected string $name;
    protected string $password;
    protected int $group_id;

}