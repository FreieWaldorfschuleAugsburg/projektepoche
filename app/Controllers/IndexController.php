<?php

namespace App\Controllers;

use function App\Helpers\getSlots;

class IndexController extends BaseController
{
    public function index(): string
    {
        if ($user = getCurrentUser()) {
            if ($user->hasVoted()) {
                [$slotVotes, $globalVotes] = getSlotVotesAndGlobalVotesByUserId($user->getId());
                return $this->render('vote/VoteView', ['user' => $user, 'slots' => getSlots(), 'template' => getVoteTemplate(), 'slotVotes' => $slotVotes, 'globalVotes' => $globalVotes]);
            }
            return $this->render('vote/VoteView', ['user' => $user, 'slots' => getSlots(), 'template' => getVoteTemplate()]);
        }

        return $this->render('LandingPageView');
    }
}