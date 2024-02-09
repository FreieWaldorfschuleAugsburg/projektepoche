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
            log_message(2, 'Upload complete');
        }
    }

    public function allUsers()
    {
        helper('user');
        $users = getUsersWithQrCode();
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

    public function fixVotes()
    {
        /*foreach (getUsers() as $user) {
            if (!$user->mayVote()) {
                getVoteModel()->where(['user_id' => $user->getId()])->delete();
            }

            $twoExists = false;
            $threeExists = false;

            $rawVotes = getVoteModel()->where(['user_id' => $user->getId()])->findAll();
            foreach ($rawVotes as $vote) {
                if ($vote->vote_id == 2) {
                    $twoExists = true;
                }

                if ($vote->vote_id == 3) {
                    $threeExists = true;
                }
            }

            if (!$twoExists) {
                //getVoteModel()->insert(['user_id' => $user->getId(), 'vote_id' => 2, 'project_id' => 73]);
                echo "Ich würde jetzt an Vote 2 für " . $user->getName() . " 73 setzen<br><br>";
            }

            if (!$threeExists) {
                //getVoteModel()->insert(['user_id' => $user->getId(), 'vote_id' => 3, 'project_id' => 73]);
                echo "Ich würde jetzt an Vote 3 für " . $user->getName() . " 73 setzen<br><br>";
            }

        }*/
    }

}