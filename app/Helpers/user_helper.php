<?php
use App\Models\UserModel;



function getUserModel(): UserModel
{
    return new UserModel();
}

function getUsers(): array
{
    return getUserModel()->findAll();
}