<?php

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

    return getGroupById($user_id);
}

/**
 * @return User[]
 */
function getUsers(): array
{
    return getUserModel()->findAll();
}


function getUser(int $userId): object|array|null
{
    return getUserModel()->find($userId);
}

function getShortName(User $user): string
{
    $firstLetter = substr($user->name, 0, 1);
    return $firstLetter . '. ' . explode(' ', $user->name)[1];


}

/**
 * @param int $id
 * @return User
 */
function getUserById(int $id): object
{
    return getUserModel()->where('id', $id)->find();
}

/**
 * @param string $name
 * @param string $password
 * @return User
 */
function getUserByUsernameAndPassword(string $name, string $password): object
{
    return getUserModel()->where('name', $name)->where('password', $password)->find();
}


function getUsersForProjectWithShortName(int $projectId): array
{
    $users = getUsersForProject($projectId);
    $shortNamedUsers = [];
    foreach ($users as $user) {
        $shortNamedUsers[] = getShortName($user);
    }

    return $shortNamedUsers;
}