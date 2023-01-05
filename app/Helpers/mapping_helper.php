<?php


function getUsersForProject(int $projectId): array
{
    $projects = getBuilder(PROJECTS_TEACHERS_MAPPING)->getWhere(['project_id' => $projectId])->getResult();
    $users = [];
    foreach ($projects as $project) {
        $users[] = getUser($project->user_id);
    }
    return $users;

}
