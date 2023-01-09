<?php

namespace App\Models;

use App\Entities\Vote;
use CodeIgniter\Model;

class VoteModel extends Model
{
    protected $table = VOTES;
    protected $primaryKey = "id";
    protected $returnType = Vote::class;

    protected $allowedFields = [
        'user_id', 'vote_id', 'project_id'
    ];
}