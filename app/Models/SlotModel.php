<?php

namespace App\Models;

use App\Entities\Slot;
use CodeIgniter\Model;

class SlotModel extends Model
{
    protected $table = SLOTS;
    protected $primaryKey = 'id';
    protected $returnType = Slot::class;
    protected $allowedFields = [
        'id', 'name', 'start_time', 'end_time'
    ];


}