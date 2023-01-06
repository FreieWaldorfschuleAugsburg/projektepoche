<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Slot extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'start_time' => null,
        'end_time' => null,
    ];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'start_time' => 'integer',
        'end_time' => 'integer'
    ];

}