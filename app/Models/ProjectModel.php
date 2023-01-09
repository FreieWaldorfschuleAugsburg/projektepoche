<?php

namespace App\Models;

use App\Entities\Project;
use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = PROJECTS;
    protected $primaryKey = "id";
    protected $returnType = Project::class;
    protected $allowedFields = [
        'slot_id', 'name', 'description'
    ];

}