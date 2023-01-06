<?php

use App\Entities\Group;
use App\Models\GroupModel;

/**
 * @param string $name
 * @return Group
 */
function getGroupByName(string $name): object
{
    return getGroupModel()->where('name', $name)->find();
}

/**
 * @param int $groupId
 * @return Group
 */
function getGroupById(int $groupId): object
{
    return getGroupModel()->find($groupId);
}

function getGroupModel(): GroupModel
{
    return new GroupModel();
}