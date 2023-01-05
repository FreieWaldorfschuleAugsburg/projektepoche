<?php

namespace App\Controllers;

class VotesController extends BaseController {
    
    public function index() {
        return $this->render('VotesView');
    }
}