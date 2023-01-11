<?php

namespace App\Controllers;

use function App\Helpers\getSlots;
use CodeIgniter\API\ResponseTrait;

class ApiController extends BaseController
{
    use ResponseTrait;

    public function uploadCredentials()
    {

        log_message(2, "Upload request");
        helper('filesystem');
        $body = $this->request->getBody();
        $postData = (array) json_decode($body);

        $userId = $postData['userId'];
        $user = getUserById($userId);
        if ($user && $postData['data']) {
            $username = str_replace(' ', '_', $user->getName());
            $groupName = $user->getGroup()->getName();

            if(!file_exists("credentials/$groupName")){
                mkdir("credentials/$groupName", 0777, true);
            }
            $decoded = base64_decode($postData['data']);
            $success =  write_file("credentials/$groupName/$username.pdf", $decoded);
        }
    }
}