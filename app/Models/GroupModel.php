<?php


namespace App\Models;
use App\Entities\Group;

class GroupModel extends \CodeIgniter\Model{
    protected $table = GROUPS;
    protected $primaryKey = "id";
    protected $returnType = Group::class;

    protected $allowedFields = [
        'id', 'name', 'admin'
    ];
}


