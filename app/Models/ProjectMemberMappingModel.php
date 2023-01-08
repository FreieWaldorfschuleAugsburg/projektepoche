<?php

namespace App\Models;

use App\Entities\Project;
use App\Entities\ProjectLeaderMapping;
use App\Entities\ProjectMemberMapping;
use CodeIgniter\Model;

class ProjectMemberMappingModel extends Model
{
    protected $table = MEMBERS;
    protected $primaryKey = "id";
    protected $returnType = ProjectMemberMapping::class;

    protected $allowedFields = [
        'user_id', 'project_id'
    ];
}