<?php

use App\Entities\User;
use App\Models\UserModel;

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