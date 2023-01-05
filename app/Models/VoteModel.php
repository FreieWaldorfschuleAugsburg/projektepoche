<?php

namespace App\Models;

use App\Entities\Vote;
use CodeIgniter\Model;
use const App\Constants\VOTES;

class VoteModel extends Model
{
    protected $table = VOTES;
    protected $primaryKey = "id";
    protected $returnType = Vote::class;
    protected $allowedFields = [
        'id', 'voter_id', 'slot_id', 'vote_id', 'project_id'
    ];

}