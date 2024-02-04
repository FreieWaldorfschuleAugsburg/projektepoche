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
    public function printAllCredentials()
    {
        helper(["api", "credential"]);
        $users = getUsersWithQrCode();
        foreach ($users as $user) {
            $groupName = $user->getGroup()->getName();
            if (!file_exists("credentials/$groupName")) {
                mkdir("credentials/$groupName", 0777, true);
            }
            $username = $user->getName();
            $password = $user->getPassword();
            $qrCode = generateQrCode($username, $password);
            $dompdf = new Dompdf([
                "defaultFont" => "Helvetica",
            ]);
            $dompdf->loadHtml(view('user/CredentialsView', ['username' => $username, 'password' => $password, 'qr' => $qrCode]));
            $dompdf->setPaper('A4');
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents("credentials/$groupName/$username.pdf", $output);
        }
        return Services::response()->setJSON(['success' => true])->setStatusCode(200);
    }

}