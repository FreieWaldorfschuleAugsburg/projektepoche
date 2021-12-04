<?php

namespace App\Controllers;

class AuthenticationController extends BaseController {
    
    public function login() {
        return $this->view('LoginView');
    }

    public function handleCredentials() {
        $db = db_connect('default');
        
        $name = trim($this->request->getPost('name'));
        $accessToken = trim($this->request->getPost('password'));

        // Check user existance
        $userRow = $db->query('SELECT * FROM projektepoche_users WHERE name LIKE ? AND password = ?', [$name, strtoupper($accessToken)])->getRow();
        if (!isset($userRow)) {
            return $this->errorRedirect($name, 'Ungültige Zugangsdaten!');
        }

        // Bind user to session
        session()->set('USER', $userRow);

        // Check group existance
        $groupRow = $db->query('SELECT * FROM projektepoche_groups WHERE id = ?', [$userRow->group_id])->getRow();
        if (!isset($groupRow)) {
            return $this->errorRedirect($name, 'Ungültige Benutzergruppe!');
        }

        // Bind group to session
        session()->set('GROUP', $groupRow);
        return redirect('dashboard');
    }

    public function update() {
        session()->remove('USER', 1);
        session()->remove('GROUP', 1);
        return redirect('/');
    }

    public function logout() {
        session()->remove('USER', 1);
        session()->remove('GROUP', 1);
        return redirect('/');
    }

    public function errorRedirect($name, $error) {
        return redirect('login')->with('name', $name)->with('error', $error);
    }
}