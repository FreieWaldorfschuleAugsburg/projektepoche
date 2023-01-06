<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

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

    public function handleCreate(): RedirectResponse
    {
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');
        $groupId = $this->request->getPost('group');

        if (!(isset($name) && isset($password) && isset($group))) {
            return redirect('users')->with('error', 'user.error.parameterMissing');
        }

        $group = getGroupById($groupId);
        if (is_null($group)) {
            return redirect('users')->with('error', 'user.error.invalidGroup');
        }

        createUser($name, $password, $group);
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

        if (!isset($id) || !isset($name) || !isset($password) || !isset($group)) {
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

        return redirect('users')->with('success', 'user.success.userDeleted');
    }
}