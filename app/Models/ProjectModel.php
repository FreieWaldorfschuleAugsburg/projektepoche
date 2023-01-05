<?php

namespace App\Models;

use App\Entities\Project;
use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = \App\Constants\PROJECTS;
    protected $primaryKey = "id";
    protected  $returnType = Project::class;

    protected $allowedFields = [
        'id', 'slot_id', 'name', 'description'
    ];



}