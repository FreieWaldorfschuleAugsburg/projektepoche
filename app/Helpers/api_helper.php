<?php
namespace App\Helpers;

function parseBody(string $body): array
{
    return (array) json_decode($body);
}