<?php

use App\Entities\Group;
use App\Models\UserModel;
use App\Entities\User;

function getUserModel(): UserModel
{
    return new UserModel();
}

/**
 * @return ?User
 */
function getCurrentUser(): ?object
{
    $user_id = session('user_id');
    if (!$user_id) {
        return null;
    }

    return getUserById($user_id);
}

/**
 * @return User[]
 */
function getUsers(): array
{
    return getUserModel()->findAll();
}

/**
 * @param int $id
 * @return ?User
 */
function getUserById(int $id): ?object
{
    return getUserModel()->find($id);
}

/**
 * @param string $name
 * @param string $password
 * @return User
 */
function getUserByUsernameAndPassword(string $name, string $password): object
{
    return getUserModel()->where(['name' => $name, 'password' => $password])->first();
}

function createUser(string $name, string $password, Group $group): void
{
    $user = new User();
    $user->setName($name);
    $user->setPassword($password);
    $user->setGroupId($group->getId());
    getUserModel()->save($user);
}

function deleteUserById(int $id): void
{
    getUserModel()->where(['id' => $id])->delete();
}

function getUserShortNamesByProjectId(int $projectId): array
{
    $leaders = getProjectLeadersByProjectId($projectId);
    $shortNames = [];
    foreach ($leaders as $leader) {
        $shortNames[] = $leader->getShortName();
    }
    return $shortNames;
}