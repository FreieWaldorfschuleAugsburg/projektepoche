<?php

use App\Entities\Project;
use App\Entities\ProjectLeaderMapping;
use App\Entities\ProjectMemberMapping;
use App\Entities\User;
use App\Models\ProjectLeaderMappingModel;
use App\Models\ProjectMemberMappingModel;
use App\Models\ProjectModel;

/**
 * @return Project[]
 */
function getProjects(): array
{
    $projects = getProjectModel()->findAll();
    usort($projects, fn($a, $b) => strcmp($a->getName(), $b->getName()));
    return $projects;
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
    $projects = getProjectModel()->where(['slot_id' => $slotId])->findAll();
    usort($projects, fn($a, $b) => strcmp($a->getName(), $b->getName()));
    return $projects;
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
 * @return User[]
 */
function getProjectMembersByProjectId(int $projectId): array
{
    $mappings = getProjectMemberMappingsByProjectId($projectId);
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

/**
 * @param int $projectId
 * @return ProjectMemberMapping[]
 */
function getProjectMemberMappingsByProjectId(int $projectId): array
{
    return getProjectMemberMappingModel()->where(['project_id' => $projectId])->findAll();
}

function updateProject(Project $project, array $leaderIds, array $memberIds): void
{
    getProjectModel()->save($project);
    getProjectLeaderMappingModel()->where(['project_id' => $project->getId()])->delete();
    insertProjectLeaderMappings($project->getId(), $leaderIds);

    getProjectMemberMappingModel()->where(['project_id' => $project->getId()])->delete();
    insertProjectMemberMappings($project->getId(), $memberIds);
}

function insertProject(Project $project, array $leaderIds, array $memberIds): void
{
    $projectId = getProjectModel()->insert($project);
    insertProjectLeaderMappings($projectId, $leaderIds);
    insertProjectMemberMappings($projectId, $memberIds);
}

function insertProjectLeaderMappings(int $projectId, array $leaderIds): void
{
    foreach ($leaderIds as $id) {
        $mapping = new ProjectLeaderMapping();
        $mapping->setUserId($id);
        $mapping->setProjectId($projectId);
        getProjectLeaderMappingModel()->insert($mapping);
    }
}

function insertProjectMemberMappings(int $projectId, array $memberIds): void
{
    foreach ($memberIds as $id) {
        $mapping = new ProjectMemberMapping();
        $mapping->setUserId($id);
        $mapping->setProjectId($projectId);
        getProjectMemberMappingModel()->insert($mapping);
    }
}

function deleteProjectById(int $projectId): void
{
    getProjectModel()->delete(['id' => $projectId]);
}

function getProjectModel(): ProjectModel
{
    return new ProjectModel();
}

function getProjectLeaderMappingModel(): ProjectLeaderMappingModel
{
    return new ProjectLeaderMappingModel();
}

function getProjectMemberMappingModel(): ProjectMemberMappingModel
{
    return new ProjectMemberMappingModel();
}

/**
 * @throws HasNoProjectsException
 */
function getProjectsForLeader(int $userId): array
{

    $mappings = getProjectLeaderMappingModel()->where(['user_id' => $userId])->findAll();

    if (!$mappings) {
        throw new HasNoProjectsException();
    }

    $projects = [];



    foreach ($mappings as $mapping) {
        $project = $mapping->getProject();
    }

    return $projects;
}

