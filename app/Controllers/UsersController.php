<?php

namespace App\Controllers;

class UsersController extends BaseController {
    
    public function index(): string
    {
        return $this->render('users/UsersView', ['users' => getUsers()]);
    }

    public function print() {
        $user = getUserById($this->request->getGet('id'));
        $this->render('users/UserPrintView', ['user' => $user], false);
    }
}