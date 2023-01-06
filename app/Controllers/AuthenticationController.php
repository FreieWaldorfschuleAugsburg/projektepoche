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
            return $this->errorRedirect($name, 'login.error.invalidCredentials');
        }

        // Bind user id to session
        session()->set('user_id', $user->getId());

        // Redirect to dashboard
        return redirect('dashboard');
    }

    public function update(): RedirectResponse
    {
        session()->remove('user_id');
        return redirect('/');
    }

    public function logout(): RedirectResponse
    {
        session()->remove('user_id');
        return redirect('/');
    }

    public function errorRedirect($name, $error): RedirectResponse {
        return redirect('login')->with('name', $name)->with('error', $error);
    }
}