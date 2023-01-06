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