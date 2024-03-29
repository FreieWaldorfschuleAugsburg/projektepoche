<?php

use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * @param string $name
 * @return string|int|null
 * @throws DatabaseException
 */
function getSettingsValue(string $name): string|int|null
{
    return getBuilder(SETTINGS)->where(['name' => $name])->get()->getRow()->value;
}

/**
 * @param string $name
 * @param string|int $value
 * @return void
 * @throws DatabaseException
 */
function setSettingsValue(string $name, string|int $value): void
{
    if (!getBuilder(SETTINGS)->update(['value' => $value], ['name' => $name])) {
        getBuilder(SETTINGS)->insert(['name' => $name, 'value' => $value]);
    }
}