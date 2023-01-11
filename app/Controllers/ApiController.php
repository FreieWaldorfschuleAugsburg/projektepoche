<?php

namespace App\Controllers;

use function App\Helpers\getSlots;
use CodeIgniter\API\ResponseTrait;

class ApiController extends BaseController
{
    use ResponseTrait;

    public function uploadCredentials()
    {
        $body = $this->request->getBody();
        $postData = (array) json_decode($body);

        $userId = $postData['userId'];
        $user = getUserById($userId);
        if ($user && $postData['data']) {
            $username = str_replace(' ', '_', $user->getName());
            $filePath = WRITEPATH . "credentials/" . str_replace(' ', '_', $user->getName()) . ".pdf";
            log_message(LOG_CRIT, $filePath);
            $decoded = base64_decode($postData['data']);
            file_put_contents("tim.pdf", $decoded);
        }
    }
}