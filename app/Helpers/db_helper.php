<?php


function getConnection(string $databaseName = 'default'): \CodeIgniter\Database\BaseConnection
{
    return db_connect($databaseName);
}

function getBuilder(string $tableName): \CodeIgniter\Database\BaseBuilder
{
    return getConnection()->table($tableName);
}
