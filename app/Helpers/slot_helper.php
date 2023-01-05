<?php

namespace App\Helpers;

function getSlots(): array
{
    return getBuilder(SLOTS)->get()->getResult();

}