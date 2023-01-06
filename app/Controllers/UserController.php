<?php

namespace App\Controllers;

class UserController extends BaseController {
    
    public function index(): string
    {
        return $this->render('user/UsersView', ['users' => getUsers()]);
    }

    public function print() {
        $user = getUserById($this->request->getGet('id'));
        $this->render('user/UserPrintView', ['user' => $user], false);
    }
}