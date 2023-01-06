<?php

use App\Entities\User;

/**
 * @param int $projectId
 * @return User[]
 */
function getUsersForProject(int $projectId): array
{
    $projects = getBuilder(PROJECTS_TEACHERS_MAPPING)->getWhere(['project_id' => $projectId])->getResult();
    $users = [];
    foreach ($projects as $project) {
        $users[] = getUserById($project->user_id);
    }
    return $users;
}
