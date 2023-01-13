<?php

namespace App\Helpers;

use App\Entities\Slot;
use App\Models\SlotModel;

/**
 * @return Slot[]
 */
function getSlots(): array
{
    $slots = getSlotModel()->findAll();
    usort($slots, fn($a, $b) => $a->getId() - $b->getId());
    return $slots;
}

/**
 * @return ?Slot
 */
function getSlotById(int $id): ?object
{
    return getSlotModel()->find($id);
}

function getSlotModel(): SlotModel
{
    return new SlotModel();
}