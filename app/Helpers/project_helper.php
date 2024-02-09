<?php

use App\Entities\Project;
use App\Entities\Membership;
use App\Entities\User;
use App\Models\MembershipModel;
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
 * @param int $memberId
 * @param int $slotId
 * @return ?Project
 * @throws DatabaseException
 */
function getProjectByMemberIdAndSlotId(int $memberId, int $slotId): ?Project
{
    $projects = getProjectsByMemberId($memberId);
    foreach ($projects as $project) {
        if ($project->getSlotId() == $slotId) {
            return $project;
        }
    }
    return null;
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
    $mappings = getProjectMembershipModel()->where(['user_id' => $userId, 'leader' => true])->findAll();

    $projects = [];
    foreach ($mappings as $mapping) {
        $projects[] = $mapping->getProject();
    }

    usort($projects, fn($a, $b) => strcmp($a->getName(), $b->getName()));
    return $projects;
}

function isProjectLeader(int $userId): bool
{
    return getProjectMembershipModel()->where(['user_id' => $userId, 'leader' => true])->countAllResults() > 0;
}

/**
 * @param int $projectId
 * @return User[]
 * @throws DatabaseException
 */
function getProjectLeadersByProjectId(int $projectId): array
{
    $mappings = getProjectMembershipModel()->where(['project_id' => $projectId, 'leader' => true])->findAll();

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
    $mappings = getProjectMembershipModel()->where(['project_id' => $projectId, 'leader' => false])->findAll();

    $users = [];
    foreach ($mappings as $mapping) {
        $users[] = $mapping->getUser();
    }
    return $users;
}

/**
 * @param int $memberId
 * @return Project[]
 * @throws DatabaseException
 */
function getProjectsByMemberId(int $memberId): array
{
    $mappings = getProjectMembershipModel()->where(['user_id' => $memberId])->findAll();

    $projects = [];
    foreach ($mappings as $mapping) {
        $projects[] = $mapping->getProject();
    }

    usort($projects, fn($a, $b) => $a->getSlotId() - $b->getSlotId());

    return $projects;
}

/**
 * @param int $projectId
 * @param int $userId
 * @return void
 * @throws DatabaseException|ReflectionException
 */
function addProjectMember(int $projectId, int $userId): void
{
    $mapping = new Membership();
    $mapping->setUserId($userId);
    $mapping->setProjectId($projectId);
    $mapping->setLeader(false);
    getProjectMembershipModel()->insert($mapping);
}

/**
 * @param int $projectId
 * @param int $userId
 * @return void
 * @throws DatabaseException
 */
function removeProjectMember(int $projectId, int $userId): void
{
    getProjectMembershipModel()->where(['project_id' => $projectId, 'user_id' => $userId])->delete();
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

    // Delete all memberships and re-insert updated leader list
    getProjectMembershipModel()->where(['project_id' => $project->getId()])->delete();
    insertProjectLeaderMappings($project->getId(), $leaderIds);
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
        $mapping = new Membership();
        $mapping->setUserId($id);
        $mapping->setProjectId($projectId);
        $mapping->setLeader(true);
        $mappings[] = $mapping;
    }

    if ($mappings) {
        getProjectMembershipModel()->insertBatch($mappings);
    }
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
        $mapping = new Membership();
        $mapping->setUserId($id);
        $mapping->setProjectId($projectId);
        $mapping->setLeader(false);
        $mappings[] = $mapping;
    }

    if ($mappings) {
        getProjectMembershipModel()->insertBatch($mappings);
    }
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

function getProjectMembershipModel(): MembershipModel
{
    return new MembershipModel();
}

