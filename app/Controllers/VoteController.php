<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use VoteState;
use function App\Helpers\getSlots;

class VoteController extends BaseController
{
    public function index(): string
    {
        return $this->render('vote/VotingView');
    }

    public function handleVote(): RedirectResponse
    {
        $user = getCurrentUser();
        $votes = $this->request->getPost('votes');

        // Check if necessary parameters are given
        if (!isset($votes)) {
            return $this->redirectWithError($votes, 'vote.voting.error.notVoted');
        }

        $template = getVoteTemplate();
        $slots = getSlots();

        $voteId = 1;
        foreach ($slots as $slot) {
            // Check if currently iterated slot is blocked
            if (isSlotBlocked($user, $slot->getId())) {
                $voteId += count($template->votes);
                continue;
            }

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

        // Insert votes
        insertVotes($user->getId(), $votes);

        return redirect('/')->with('success', 'vote.voting.success');
    }

    public function handleStateChange(): RedirectResponse
    {
        $stateId = $this->request->getGet('id');
        $state = VoteState::from($stateId);

        if ($state == VoteState::CLOSED) {


        } else if ($state == VoteState::PUBLIC) {

        }

        setVoteState($state);
        return redirect('voting');
    }

    public function handleReset(): RedirectResponse
    {
        deleteAllVotes();
        setVoteState(VoteState::CLOSED);
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