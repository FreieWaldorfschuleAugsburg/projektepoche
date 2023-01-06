<?php

namespace App\Helpers;

function getSlots(): array
{
    return getBuilder(SLOTS)->get()->getResult();
}

function getSlotsWithProjectAndUser(): array
{
    $slotsWithProject = [];
    $slots = getSlots();

    foreach ($slots as $slot) {
        $projects = getProjectsWithUserBySlotId($slot->id);
        $slotsWithProject[] = ['slot' => $slot, 'projects' => $projects];
    }

    return $slotsWithProject;
}
