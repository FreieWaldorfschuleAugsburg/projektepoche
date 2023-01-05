<?php


function getUsers(): array
{
    return getBuilder(USERS)->get()->getResult();
}