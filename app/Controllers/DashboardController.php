<?php

namespace App\Controllers;

use function App\Helpers\getSlotsWithProjectAndUser;

class DashboardController extends BaseController {
    
    public function index(): string
    {
        $data = [...getSlotsWithProjectAndUser()];
        return $this->render('DashboardView', ['data' => $data, 'votes' => [], 'mayVote' => true, 'voteOpen' => false]);
    }
}