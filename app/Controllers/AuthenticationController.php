<?php

namespace App\Controllers;

class AuthenticationController extends BaseController {
    
    public function login() {
        $db = db_connect('default');
        
        $name = $this->request->getPost('name');
        $accessToken = $this->request->getPost('accessToken');

        $row = $db->query('SELECT * FROM projektepoche_users WHERE name LIKE ? AND access_token = ?', [$name, strtoupper($accessToken)])->getRow();
        if (!isset($row)) {
            return $this->errorRedirect('Ungültige Zugangsdaten!');
        }

        session()->set('USER_ID', $row->id);
        session()->set('USER_NAME', $row->name);
        return redirect('dashboard');
    }

    public function logout() {
        session()->remove('USER_ID', 1);
        return redirect('/');
    }

    public function errorRedirect($error) {
        return redirect('/')->with('error', $error);
    }
}