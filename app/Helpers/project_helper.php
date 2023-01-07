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

function updateProject(Project $project, array $leaderIds): void
{
    getProjectModel()->save($project);
    getProjectLeaderMappingModel()->where(['project_id' => $project->getId()])->delete();
    insertProjectLeaderMapping($project->getId(), $leaderIds);
}

function insertProject(Project $project, array $leaderIds): void
{
    $projectId = getProjectModel()->insert($project);
    insertProjectLeaderMapping($projectId, $leaderIds);
}

function insertProjectLeaderMapping(int $projectId, array $leaderIds): void
{
    foreach ($leaderIds as $id) {
        $mapping = new ProjectLeaderMapping();
        $mapping->setUserId($id);
        $mapping->setProjectId($projectId);
        getProjectLeaderMappingModel()->insert($mapping);
    }
}

function deleteProjectById(int $projectId): void
{
    getProjectModel()->where(['id' => $projectId])->delete();
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