<?php

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;

function getBuilder(string $tableName): BaseBuilder
{
    return getConnection()->table($tableName);
}

function getConnection(string $databaseName = 'default'): BaseConnection
{
    return db_connect($databaseName);
}