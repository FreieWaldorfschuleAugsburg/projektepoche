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
        if (getVoteState() != VoteState::OPEN) {
            return $this->redirectWithError([], 'vote.voting.error.voteClosed');
        }

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

        // Determine state from id
        $state = VoteState::from($stateId);

        // Write new state to database
        setVoteState($state);

        if ($state == VoteState::CLOSED) {
            // Automatically put everybody in their first priority project
            $users = getUsers();

            // TODO shall we keep it random?
            shuffle($users);
            usort($users, fn($a, $b) => $b->getGroupId() - $a->getGroupId());

            foreach ($users as $user) {
                if (!$user->mayVote() || !$user->hasVoted()) continue;

                foreach (getVotesByUserId($user->getId()) as $votes) {
                    addProjectMember($votes[1]->getProjectId(), $user->getId());
                }
            }
        }

        return redirect('voting')->with('success', 'vote.voting.stateChangeSuccess');;
    }

    public function handleReset(): RedirectResponse
    {
        deleteAllVotes();
        setVoteState(VoteState::CLOSED);
        return redirect('voting')->with('success', 'vote.voting.resetSuccess');
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