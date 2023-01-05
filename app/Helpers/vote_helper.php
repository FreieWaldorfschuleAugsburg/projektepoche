<?php


use App\Models\GroupModel;

function getGroupModel(): GroupModel
{
    return new GroupModel();
}


function getGroupByName(string $name): array
{
    return getGroupModel()->where('name', $name)->find();
}

function getGroupById(int $groupId): object|array|null
{
    return getGroupModel()->find($groupId);

}