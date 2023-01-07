<?php

use App\Entities\Group;
use App\Models\GroupModel;

/**
 * @param string $name
 * @return ?Group
 */
function getGroupByName(string $name): ?object
{
    return getGroupModel()->where('name', $name)->first();
}

/**
 * @param int $groupId
 * @return ?Group
 */
function getGroupById(int $groupId): ?object
{
    return getGroupModel()->find($groupId);
}

/**
 * @return Group[]
 */
function getGroups(): array
{
    return getGroupModel()->findAll();
}

function getGroupModel(): GroupModel
{
    return new GroupModel();
}