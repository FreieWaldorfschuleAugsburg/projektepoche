<?php

namespace App\Helpers;

use App\Entities\Slot;
use App\Models\SlotModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * @return Slot[]
 * @throws DatabaseException
 */
function getSlots(): array
{
    $slots = getSlotModel()->findAll();
    usort($slots, fn($a, $b) => $a->getId() - $b->getId());
    return $slots;
}

/**
 * @return ?Slot
 * @throws DatabaseException
 */
function getSlotById(int $id): ?object
{
    return getSlotModel()->find($id);
}

function getSlotModel(): SlotModel
{
    return new SlotModel();
}