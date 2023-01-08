<?php

namespace App\Helpers;

use App\Entities\Slot;
use App\Models\SlotModel;

/**
 * @return Slot[]
 */
function getSlots(): array
{
    return getSlotModel()->findAll();
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