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

function getSlotsWithProjectAndUser(): array
{
    $slotsWithProject = [];
    $slots = getSlots();

    foreach ($slots as $slot) {
        $projects = getProjectsWithUserBySlotId($slot->getId());
        $slotsWithProject[] = ['slot' => $slot, 'projects' => $projects];
    }

    return $slotsWithProject;
}
