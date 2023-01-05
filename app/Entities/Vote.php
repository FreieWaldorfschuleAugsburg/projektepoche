<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Vote extends Entity
{
    public int $id;
    public int $voter_id;
    public int $slot_id;
    public int $vote_id;
    public int $project_id;
}