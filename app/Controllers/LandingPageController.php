<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\getSlotsWithProjectAndUser;

class LandingPageController extends BaseController
{
    public function index(): string|RedirectResponse
    {
        if (getCurrentUser()) {
            return redirect('dashboard');
        }

        $slots = getSlotsWithProjectAndUser();
        return $this->render('LandingPageView', ['data' => $slots]);
    }
}