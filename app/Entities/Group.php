<?php


namespace App\Entities;
class Group extends \CodeIgniter\Entity\Entity
{
    protected int $id;
    protected string $name;
    protected bool $admin;

}