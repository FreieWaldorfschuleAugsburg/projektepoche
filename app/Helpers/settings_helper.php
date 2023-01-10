<?php

/**
 * @param string $name
 * @return string|int|null
 */
function getSettingsValue(string $name): string|int|null
{
    return getBuilder(SETTINGS)->where(['name' => $name])->get()->getRow()->value;
}

function setSettingsValue(string $name, string|int $value): void
{
    if (!getBuilder(SETTINGS)->update(['value' => $value], ['name' => $name])) {
        getBuilder(SETTINGS)->insert(['name' => $name, 'value' => $value]);
    }
}