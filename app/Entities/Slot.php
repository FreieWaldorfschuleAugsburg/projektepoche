<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Slot extends Entity
{
    protected $attributes = [
        'id' => null,
        'start_time' => null,
        'end_time' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'start_time'
    ];

}