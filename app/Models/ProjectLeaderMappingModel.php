<?php

namespace App\Models;

use App\Entities\Project;
use App\Entities\ProjectLeaderMapping;
use CodeIgniter\Model;

class ProjectLeaderMappingModel extends Model
{
    protected $table = LEADERS;
    protected $primaryKey = "id";
    protected $returnType = ProjectLeaderMapping::class;

    protected $allowedFields = [
        'user_id', 'project_id'
    ];
}