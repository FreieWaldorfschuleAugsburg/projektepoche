<?php

namespace App\Controllers;

class DashboardController extends BaseController {
    
    public function index() {
        return $this->view('DashboardView');
    }
}