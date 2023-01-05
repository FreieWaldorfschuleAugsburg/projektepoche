<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class AuthenticationController extends BaseController {
    
    public function login(): string
    {
        return $this->render('LoginView');
    }

    public function handleCredentials(): RedirectResponse
    {
        $name = trim($this->request->getPost('name'));
        $password = trim($this->request->getPost('password'));
        $user = getUserByUsernameAndPassword($name, $password);

        // Check user existence
        if (!$user) {
            return $this->errorRedirect($name, 'Ungültige Zugangsdaten!');
        }

        // Bind user to session
        session()->set('USER', $user);

        // Check group existence
        $group = getGroupById($user->group_id);
        if (!$group) {
            return $this->errorRedirect($name, 'Ungültige Benutzergruppe!');
        }

        // Bind group to session
        session()->set('GROUP', $group);

        // Redirect to dashboard
        return redirect('dashboard');
    }

    public function update(): RedirectResponse
    {
        session()->remove('USER');
        session()->remove('GROUP');
        return redirect('/');
    }

    public function logout(): RedirectResponse
    {
        session()->remove('USER');
        session()->remove('GROUP');
        return redirect('/');
    }

    public function errorRedirect($name, $error): RedirectResponse {
        return redirect('login')->with('name', $name)->with('error', $error);
    }
}