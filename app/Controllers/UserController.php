<?php

namespace App\Controllers;

use App\Entities\User;
use CodeIgniter\HTTP\RedirectResponse;
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

    public function print(): string|RedirectResponse
    {
        $id = $this->request->getGet('id');
        if (!isset($id)) {
            return redirect('users')->with('error', 'user.error.parameterMissing');
        }

        $user = getUserById($id);
        if (is_null($user)) {
            return redirect('users')->with('error', 'user.error.invalidUser');
        }

        return $this->render('user/UserPrintView', ['user' => $user], false);
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

    public function handleImport()
    {

        $intent = $this->request->getPost('intent');
        helper('import');
        if ($intent === 'confirm') {
            $users = getUsersFromForm($this->request);
            foreach ($users as $user){
                saveUser($user);
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


}