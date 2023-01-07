<?php

namespace App\Controllers;

class IndexController extends BaseController
{
    public function index(): string
    {
        if ($user = getCurrentUser()) {
            return $this->render('vote/VoteView', ['user' => $user, 'votes' => [], 'voteOpen' => false]);
        }

        return $this->render('LandingPageView');
    }
}