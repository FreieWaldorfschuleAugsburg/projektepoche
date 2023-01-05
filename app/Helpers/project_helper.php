<?php


function getProjects(): array
{
    return getBuilder(PROJECTS)->get()->getResult();
}


function getProjectsBySlotId(int $slotId): array
{
    return getBuilder(PROJECTS)->getWhere(['slot_id' => $slotId])->getResult();


}