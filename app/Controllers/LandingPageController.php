<?php

namespace App\Controllers;

use function App\Helpers\getSlots;
use function App\Helpers\getSlotsWithProjectAndUser;

class LandingPageController extends BaseController
{

    public function index(): string
    {
        // Redirect to dashboard if user is logged in
        $slots = getSlotsWithProjectAndUser();
        return $this->render('LandingPageView', ['data' => $slots]);
    }
}