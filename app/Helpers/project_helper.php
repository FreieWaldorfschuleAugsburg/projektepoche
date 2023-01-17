<?php

use App\Entities\Project;
use App\Entities\ProjectLeaderMapping;
use App\Entities\ProjectMemberMapping;
use App\Entities\User;
use App\Models\ProjectLeaderMappingModel;
use App\Models\ProjectMemberMappingModel;
use App\Models\ProjectModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * @return Project[]
 * @throws DatabaseException
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
 * @throws DatabaseException
 */
function getProjectById(int $id): ?object
{
    return getProjectModel()->find($id);
}

/**
 * @param int $slotId
 * @return Project[]
 * @throws DatabaseException
 */
function getProjectsBySlotId(int $slotId): array
{
    $projects = getProjectModel()->where(['slot_id' => $slotId])->findAll();
    usort($projects, fn($a, $b) => strcmp($a->getName(), $b->getName()));
    return $projects;
}

/**
 * @param int $userId
 * @return Project[]
 * @throws DatabaseException
 */
function getProjectsByLeader(int $userId): array
{
    $mappings = getProjectLeaderMappingModel()->where(['user_id' => $userId])->findAll();

    $projects = [];
    foreach ($mappings as $mapping) {
        $projects[] = $mapping->getProject();
    }

    usort($projects, fn($a, $b) => strcmp($a->getName(), $b->getName()));
    return $projects;
}

function isProjectLeader(int $userId): bool
{
    return getProjectLeaderMappingModel()->where(['user_id' => $userId])->countAllResults() > 0;
}

/**
 * @param int $projectId
 * @return User[]
 * @throws DatabaseException
 */
function getProjectLeadersByProjectId(int $projectId): array
{
    $mappings = getProjectLeaderMappingModel()->where(['project_id' => $projectId])->findAll();

    $users = [];
    foreach ($mappings as $mapping) {
        $users[] = $mapping->getUser();
    }
    return $users;
}

/**
 * @param int $projectId
 * @return User[]
 * @throws DatabaseException
 */
function getProjectMembersByProjectId(int $projectId): array
{
    $mappings = getProjectMemberMappingModel()->where(['project_id' => $projectId])->findAll();

    $users = [];
    foreach ($mappings as $mapping) {
        $users[] = $mapping->getUser();
    }
    return $users;
}

/**
 * @param int $projectId
 * @param int $userId
 * @return void
 * @throws DatabaseException|ReflectionException
 */
function addProjectMember(int $projectId, int $userId): void
{
    $mapping = new ProjectMemberMapping();
    $mapping->setUserId($userId);
    $mapping->setProjectId($projectId);
    getProjectMemberMappingModel()->insert($mapping);
}

/**
 * @param int $projectId
 * @param int $userId
 * @return void
 * @throws DatabaseException
 */
function removeProjectMember(int $projectId, int $userId): void
{
    getProjectMemberMappingModel()->where(['project_id' => $projectId, 'user_id' => $userId])->delete();
}

/**
 * @param Project $project
 * @param array $leaderIds
 * @param array $memberIds
 * @return void
 * @throws DatabaseException|ReflectionException
 */
function updateProject(Project $project, array $leaderIds, array $memberIds): void
{
    // Update project entry
    getProjectModel()->save($project);

    // Delete all leaders and re-insert updated leader list
    getProjectLeaderMappingModel()->where(['project_id' => $project->getId()])->delete();
    insertProjectLeaderMappings($project->getId(), $leaderIds);

    // Delete all members and re-insert updated member list
    getProjectMemberMappingModel()->where(['project_id' => $project->getId()])->delete();
    insertProjectMemberMappings($project->getId(), $memberIds);
}

/**
 * @param Project $project
 * @param array $leaderIds
 * @param array $memberIds
 * @return void
 * @throws DatabaseException|ReflectionException
 */
function insertProject(Project $project, array $leaderIds, array $memberIds): void
{
    // Insert project entry
    $projectId = getProjectModel()->insert($project);

    // Insert leaders
    insertProjectLeaderMappings($projectId, $leaderIds);

    // Insert members
    insertProjectMemberMappings($projectId, $memberIds);
}

/**
 * @param int $projectId
 * @param array $leaderIds
 * @return void
 * @throws DatabaseException|ReflectionException
 */
function insertProjectLeaderMappings(int $projectId, array $leaderIds): void
{
    $mappings = [];
    foreach ($leaderIds as $id) {
        $mapping = new ProjectLeaderMapping();
        $mapping->setUserId($id);
        $mapping->setProjectId($projectId);
        $mappings[] = $mapping;
    }
    getProjectLeaderMappingModel()->insertBatch($mappings);
}

/**
 * @param int $projectId
 * @param array $memberIds
 * @return void
 * @throws DatabaseException|ReflectionException
 */
function insertProjectMemberMappings(int $projectId, array $memberIds): void
{
    $mappings = [];
    foreach ($memberIds as $id) {
        $mapping = new ProjectMemberMapping();
        $mapping->setUserId($id);
        $mapping->setProjectId($projectId);
        $mappings[] = $mapping;
    }
    getProjectMemberMappingModel()->insertBatch($mappings);
}

/**
 * @param int $projectId
 * @return void
 * @throws DatabaseException
 */
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

