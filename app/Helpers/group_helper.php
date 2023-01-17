<?php

use App\Entities\Group;
use App\Models\GroupModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * @param string $name
 * @return ?Group
 * @throws DatabaseException
 */
function getGroupByName(string $name): ?object
{
    return getGroupModel()->where('name', $name)->first();
}

/**
 * @param int $groupId
 * @return ?Group
 * @throws DatabaseException
 */
function getGroupById(int $groupId): ?object
{
    return getGroupModel()->find($groupId);
}

/**
 * @return Group[]
 * @throws DatabaseException
 */
function getGroups(): array
{
    return getGroupModel()->findAll();
}

function getGroupModel(): GroupModel
{
    return new GroupModel();
}