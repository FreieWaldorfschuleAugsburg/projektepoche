<?php

namespace App\Controllers;

use function App\Helpers\getSlots;

class IndexController extends BaseController
{
    public function index()
    {
        if ($user = getCurrentUser()) {
            if ($user->hasVoted()) {
                $votes = getVotesByUserId($user->getId());
                return $this->render('vote/VoteView', ['user' => $user, 'slots' => getSlots(), 'template' => getVoteTemplate(), 'votes' => $votes]);
            }
            return $this->render('vote/VoteView', ['user' => $user, 'slots' => getSlots(), 'template' => getVoteTemplate()]);
        }

        return $this->render('LandingPageView');
    }
}