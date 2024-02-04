<?php


namespace App\Controllers;


use Config\Services;
use Dompdf\Options;
use function App\Helpers\getSlots;
use CodeIgniter\API\ResponseTrait;
use function App\Helpers\parseBody;
use Dompdf\Dompdf;


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

    public function generateServersidePdf()
    {
        helper(["api", "credential"]);
        $username = "MyUser";
        $password = "MyPassword";
        $qrCode = generateQrCode($username, $password);
        $options = new Options();
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('user/CredentialsView', ['username' => $username, 'password' => $password, 'qr' => $qrCode]));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('MyUser.pdf', $output);
        return Services::response()->setJSON([
            'imageurl' => $qrCode
        ])->setStatusCode(200);
    }


}