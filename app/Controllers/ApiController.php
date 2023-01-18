<?php

namespace App\Controllers;

use Config\Services;
use function App\Helpers\getSlots;
use CodeIgniter\API\ResponseTrait;
use function App\Helpers\parseBody;

class ApiController extends BaseController
{
    use ResponseTrait;

    public function uploadCredentials()
    {
        helper(['filesystem', 'api']);
        $postData = parseBody($this->request->getBody());
        $userId = $postData['userId'];
        $user = getUserById($userId);
        if ($user && $postData['data']) {
            $username = str_replace(' ', '_', $user->getName());
            $groupName = $user->getGroup()->getName();

            if (!file_exists("credentials/$groupName")) {
                mkdir("credentials/$groupName", 0777, true);
            }
            $decoded = base64_decode($postData['data']);
            write_file("credentials/$groupName/$username.pdf", $decoded);
        }
    }

    public function allUsers()
    {
        $users = getUsers();
        return $this->respond($users, 200);
    }

    public function renderQr(): \CodeIgniter\HTTP\Response
    {
        helper(['api', 'credential']);
        $data = parseBody($this->request->getBody());
        $username = $data['username'];
        $password = $data['password'];
        $qrCode = generateQrCode($username, $password);


        return Services::response()->setJSON([
            'imageurl' => $qrCode
        ])->setStatusCode(200);
    }


}