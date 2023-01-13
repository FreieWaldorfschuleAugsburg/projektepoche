<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\getSlots;

class VoteController extends BaseController
{

    public function index(): string
    {
        return $this->render('vote/VotingView');
    }

    public function handleVote(): RedirectResponse
    {
        $votes = $this->request->getPost('votes');

        if (!isset($votes)) {
            return $this->redirectWithError($votes, 'vote.voting.error.notVoted');
        }

        $template = getVoteTemplate();
        $slots = getSlots();

        $voteId = 0;
        foreach ($slots as $slot) {
            $slotVotes = [];
            foreach ($template->votes as $vote) {
                if (!array_key_exists($voteId, $votes)) {
                    return $this->redirectWithError($votes, 'vote.voting.error.voteMissing', $slot->getName(), $vote->name->{$this->request->getLocale()});
                }

                $slotVotes[] = $votes[$voteId];
                $voteId++;
            }

            // Verify that no duplicates exist
            if (count(array_unique($slotVotes)) < count($slotVotes)) {
                return $this->redirectWithError($votes, 'vote.voting.error.duplicateProject', $slot->getName());
            }
        }

        $userId = getCurrentUser()->getId();

        // Insert votes
        $voteId = 0;
        foreach ($votes as $vote) {
            insertVote($userId, $voteId, $vote);
            $voteId++;
        }

        return redirect('/')->with('success', 'vote.voting.success');
    }

    public function handleStateChange(): RedirectResponse
    {
        $stateId = $this->request->getGet('id');
        $state = \VoteState::from($stateId);
        setVoteState($state);

        /**
         * TODO handle state change
         *
         * on OPEN: delete all votes
         * on CLOSED: add all users to the frist slotVote project
         * on PUBLIC: only allow if conflicts are solved
         */

        return redirect('voting');
    }

    public function handleReset(): RedirectResponse
    {
        setVoteState(\VoteState::CLOSED);

        /**
         * TODO handle reset
         */

        return redirect('voting');
    }

    public function redirectWithError($votes, $error, ...$data): RedirectResponse
    {
        $response = redirect('/')->with('votes', $votes)->with('error', $error);
        if ($data) {
            $response->with('data', $data);
        }
        return $response;
    }
}