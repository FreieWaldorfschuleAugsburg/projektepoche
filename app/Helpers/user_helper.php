<?php

use App\Models\UserModel;

function getUserModel(): UserModel
{
    return new UserModel();
}

/**
 * @return ?UserModel
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
 * @return UserModel[]
 */
function getUsers(): array
{
    return getUserModel()->findAll();
}

/**
 * @param int $id
 * @return UserModel
 */
function getUserById(int $id): object
{
    return getUserModel()->where('id', $id)->find();
}

/**
 * @param string $name
 * @param string $password
 * @return UserModel
 */
function getUserByUsernameAndPassword(string $name, string $password): object
{
    return getUserModel()->where('name', $name)->where('password', $password)->find();
}