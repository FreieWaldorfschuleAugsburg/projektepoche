<?php

namespace App\Controllers;

class VotesController extends BaseController {
    
    public function index() {
        if (!session('USER') || !session('GROUP')){
            return redirect('login')->with('error', 'Sitzung abgelaufen. Erneut anmelden!');
        }

        return $this->view('VotesView');
    }
}