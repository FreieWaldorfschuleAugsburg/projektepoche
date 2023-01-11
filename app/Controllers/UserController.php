<?php

namespace App\Controllers;

use App\Entities\User;
use GuzzleHttp\Client;
use CodeIgniter\HTTP\RedirectResponse;
use GuzzleHttp\Exception\GuzzleException;
use function App\Helpers\deleteDirectoryRecursively;
use function App\Helpers\getFileName;
use function App\Helpers\getFilePath;
use function App\Helpers\getImportKeys;
use function App\Helpers\getUserUploadsFolder;
use function App\Helpers\readCsvToArray;
use function App\Helpers\storeFile;


class UserController extends BaseController
{

    public function index(): string
    {
        //make sure there are no leftover credentials that could be leaked
        deleteDirectoryRecursively('credentials');
        return $this->render('user/UsersView', ['users' => getUsers()]);
    }

    public function create(): string
    {
        return $this->render('user/UserCreateView', ['groups' => getGroups()]);
    }

    public function handleCreate(): string|RedirectResponse
    {
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');
        $groupId = $this->request->getPost('group');

        if (!isset($name) || !isset($password) || !isset($groupId)) {
            return redirect('users')->with('error', 'user.error.parameterMissing');
        }

        $group = getGroupById($groupId);
        if (is_null($group)) {
            return redirect('users')->with('error', 'user.error.invalidGroup');
        }

        $user = new User();
        $user->setName($name);
        $user->setPassword($password);
        $user->setGroupId($group->getId());
        saveUser($user);

        return redirect('users')->with('success', 'user.success.userCreated');
    }

    public function edit(): string|RedirectResponse
    {
        $id = $this->request->getGet('id');
        if (!isset($id)) {
            return redirect('users')->with('error', 'user.error.parameterMissing');
        }

        $user = getUserById($id);
        if (is_null($user)) {
            return redirect('users')->with('error', 'user.error.invalidUser');
        }

        return $this->render('user/UserEditView', ['user' => $user, 'groups' => getGroups()]);
    }

    public function handleEdit(): RedirectResponse
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');
        $groupId = $this->request->getPost('group');

        if (!isset($id) || !isset($name) || !isset($password) || !isset($groupId)) {
            return redirect('users')->with('error', 'user.error.parameterMissing');
        }

        $user = getUserById($id);
        if (is_null($user)) {
            return redirect('users')->with('error', 'user.error.invalidUser');
        }

        $group = getGroupById($groupId);
        if (is_null($group)) {
            return redirect('users')->with('error', 'user.error.invalidGroup');
        }

        $user->setName($name);
        $user->setPassword($password);
        $user->setGroupId($group->getId());
        saveUser($user);

        return redirect('users')->with('success', 'user.success.userEdited');
    }

    public function print()
    {
        helper('credential');

        $id = $this->request->getGet('id');
        $printAll = $this->request->getGet('printAll');
        if (!isset($id)) {
            return redirect('users')->with('error', 'user.error.parameterMissing');
        }

        $user = getUserById($id);
        if (is_null($user) && $printAll) {
            log_message(2, 'printing');
            return $this->response->redirect(base_url('users/credentials/download'));
        }

        if (is_null($user)) {
            return redirect('users')->with('error', 'user.error.invalidUser');
        }

        return $this->render('user/UserPrintView', ['user' => $user, 'qr' => generateQrCode($user)], false, false);
    }

    public function printAll()
    {
        return $this->response->redirect(base_url('user/print?id=1&printAll=true'));
    }

    public function downloadCredentials()
    {
        $path = realpath('credentials');
        if (file_exists($path)) {
            $zipFileName = 'credentials.zip';
            $zip = new \ZipArchive();
            $zip->open($zipFileName, \ZipArchive::CREATE);
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );
            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($path) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
            header("Content-disposition: attachment; filename=$zipFileName");
            header('Content-type: application/zip');
            readfile($zipFileName);
            unlink($zipFileName);
        } else  return redirect('users');
    }


    public function delete(): RedirectResponse
    {
        $id = $this->request->getGet('id');
        if (!isset($id)) {
            return redirect('users')->with('error', 'user.error.parameterMissing');
        }
        $user = getUserById($id);

        if (is_null($user)) {
            return redirect('users')->with('error', 'user.error.invalidUser');
        }

        deleteUserById($id);
        return redirect('users')->with('success', 'user.success.userDeleted');
    }


    public function import(): string
    {
        return $this->render('user/UserImportView');
    }

    /**
     * @throws \Exception
     */
    public function handleImport()
    {

        $intent = $this->request->getPost('intent');
        helper('import');
        if ($intent === 'confirm') {
            try {
                $users = getUsersFromForm($this->request);
                foreach ($users as $user) {
                    saveUser($user);
                }
            } catch (\Exception $exception) {
                return redirect('users')->with('error', $exception->getMessage());
            }
            return redirect('users')->with('success', lang('user.import.success.saved'));
        }

        if ($intent === 'import') {
            $filePath = storeFile($this->request);
            $importKeys = getImportKeys($this->request);
            $userData = readCsvToArray($filePath);
            [$users, $errors] = getUsersFromFile($userData, $importKeys);
            return $this->render('user/UserImportView', ['users' => $users, 'errors' => $errors]);
        }
    }


    public function code()
    {
        helper('credential');
        $code = $this->request->getGet('code');
        if (!isset($code)) {
            return redirect('users')->with('error', 'user.error.parameterMissing');
        }
        try {
            $user = checkCode($code);
            session()->set('user_id', $user->getId());
            return redirect('/');

        } catch (\Exception $e) {
            return redirect('login')->with('error', $e->getMessage());
        }

    }


}