<?php

namespace App\Controllers;

use function App\Helpers\getSlots;
use function App\Helpers\getSlotsWithProjectAndUser;

class LandingPageController extends BaseController
{

    public function index()
    {
        // Redirect to dashboard if user is logged in
        if (session('USER') && session('GROUP')) {
            return redirect('dashboard');
        }
        $slots = getSlotsWithProjectAndUser();
        return $this->render('LandingPageView', ['data' => $slots]);
    }
}