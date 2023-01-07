<?php

use App\Entities\Project;
use App\Entities\ProjectLeaderMapping;
use App\Entities\User;
use App\Models\ProjectLeaderMappingModel;
use App\Models\ProjectModel;

/**
 * @return Project[]
 */
function getProjects(): array
{
    return getProjectModel()->findAll();
}

/**
 * @param int $id
 * @return ?Project
 */
function getProjectById(int $id): ?object
{
    return getProjectModel()->find($id);
}

/**
 * @param int $slotId
 * @return Project[]
 */
function getProjectsBySlotId(int $slotId): array
{
    return getProjectModel()->where(['slot_id' => $slotId])->findAll();
}

/**
 * @param int $projectId
 * @return User[]
 */
function getProjectLeadersByProjectId(int $projectId): array
{
    $mappings = getProjectLeaderMappingsByProjectId($projectId);
    $users = [];
    foreach ($mappings as $mapping) {
        $users[] = $mapping->getUser();
    }
    return $users;
}

/**
 * @param int $projectId
 * @return ProjectLeaderMapping[]
 */
function getProjectLeaderMappingsByProjectId(int $projectId): array
{
    return getProjectLeaderMappingModel()->where(['project_id' => $projectId])->findAll();
}

function insertProject(Project $project): int
{
    return getProjectModel()->insert($project);
}

function insertProjectLeaderMapping(ProjectLeaderMapping $mapping): int
{
    return getProjectLeaderMappingModel()->insert($mapping);
}

function getProjectsWithUserBySlotId(int $slotId): array
{
    $projectsWithUser = [];
    $projects = getProjectsBySlotId($slotId);
    foreach ($projects as $project) {
        $teachers = getUserShortNamesByProjectId($project->getId());
        $projectsWithUser[] = ['handle' => $project, 'teachers' => $teachers];
    }
    return $projectsWithUser;
}

function getProjectModel(): ProjectModel
{
    return new ProjectModel();
}

function getProjectLeaderMappingModel(): ProjectLeaderMappingModel
{
    return new ProjectLeaderMappingModel();
}