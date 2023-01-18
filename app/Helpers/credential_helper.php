<?php

use App\Entities\User;
use chillerlan\QRCode\QRCode;

function generateQrCode(string $username, string $password)
{
    $token = generateToken($username, $password);
    $url = base_url("code?code=$token");
    $qr = new QRCode();
    return $qr->render($url);
}

/**
 * @throws Exception
 */
function checkCode(string $code): object
{
    $decryptedCode = decryptData($code);
    $userData = (array)json_decode($decryptedCode);
    $user = getUserByUsernameAndPassword($userData['name'], $userData['password']);
    if (!$user) {
        throw new Exception('login.error.invalidCredentials');
    }

    return $user;
}


function generateToken(string $username, string $password): bool|string
{
    $plain = json_encode(['name' => $username, 'password' => $password]);
    return urlencode(encryptData($plain));
}

function encryptData(string $data): bool|string
{
    return openssl_encrypt($data, 'aes-256-cbc', env("app.encryption.key"), 0, env('app.encryption.iv'));
}

function decryptData(string $data): bool|string
{
    return openssl_decrypt($data, 'aes-256-cbc', env('app.encryption.key'), 0, env('app.encryption.iv'));
}

/**
 * @throws Exception
 */
