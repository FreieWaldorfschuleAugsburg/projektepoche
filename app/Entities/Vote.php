<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Vote extends Entity
{
    protected int $id;
    protected int $voter_id;
    protected int $slot_id;
    protected int $vote_id;
    protected int $project_id;

}