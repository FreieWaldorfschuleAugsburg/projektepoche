<?php

use App\Entities\Project;

/**
 * @return Project[]
 */
function getProjects(): array
{
    return getBuilder(PROJECTS)->get()->getResult();
}

/**
 * @param int $slotId
 * @return Project[]
 */
function getProjectsBySlotId(int $slotId): array
{
    return getBuilder(PROJECTS)->getWhere(['slot_id' => $slotId])->getResult();
}

function getProjectsWithUserForSlot(int $slotId): array
{
    $projectsWithUser = [];
    $projects = getProjectsBySlotId($slotId);
    foreach ($projects as $project){
        $teachers = getUsersForProjectWithShortName($project->id);
        $projectsWithUser[] = ['handle' => $project, 'teachers' => $teachers];
    }
    return $projectsWithUser;
}