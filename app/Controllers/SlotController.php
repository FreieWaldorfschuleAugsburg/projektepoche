<?php

namespace App\Controllers;

use App\Entities\Project;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\getSlotById;
use function App\Helpers\getSlots;

class SlotController extends BaseController
{
    public function index(): string
    {
        return $this->render('slot/SlotsView', ['slots' => getSlots()]);
    }
}