<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\getSlots;

class ConflictController extends BaseController
{

    public function index(): string
    {
        return $this->render('conflict/ConflictsView');
    }
}