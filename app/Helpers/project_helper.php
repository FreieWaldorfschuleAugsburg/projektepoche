<?php


function getProjects(): array
{
    return getBuilder(PROJECTS)->get()->getResult();
}


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