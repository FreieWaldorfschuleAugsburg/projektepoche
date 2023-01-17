<?php

namespace App\Helpers;

use CodeIgniter\HTTP\IncomingRequest;

function getImportKeys(IncomingRequest $request): array
{
    $firstName = $request->getPost('keys_firstName');
    $lastName = $request->getPost('keys_lastName');
    $grade = $request->getPost('keys_grade');

    return ['firstName' => $firstName, 'lastName' => $lastName, 'grade' => $grade];
}