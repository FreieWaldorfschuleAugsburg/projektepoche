<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use Shuchkin\SimpleXLSXGen;
use function App\Helpers\getSlots;

class VoteController extends BaseController
{

    public function index(): string
    {
        return $this->render('vote/VotesView');
    }

    public function handleVote(): RedirectResponse
    {
        $slotVotes = $this->request->getPost('slotVotes');
        $globalVotes = $this->request->getPost('globalVotes');

        if (!isset($slotVotes)) {
            return $this->redirectWithError($slotVotes, $globalVotes, 'vote.voting.error.notVoted');
        }

        $templateFile = file_get_contents(VOTE_TEMPLATE_CONFIG);
        $template = json_decode($templateFile);

        $slots = getSlots();
        $allProjects = [];
        foreach ($slots as $slot) {
            // Verify if votes for current slot exist
            if (!array_key_exists($slot->getId(), $slotVotes)) {
                return $this->redirectWithError($slotVotes, $globalVotes, 'vote.voting.error.slotMissing', $slot->getName());
            }

            $votes = $slotVotes[$slot->getId()];

            foreach ($template->slotVotes as $vote) {
                if (!array_key_exists($vote->id, $votes)) {
                    return $this->redirectWithError($slotVotes, $globalVotes, 'vote.voting.error.voteMissing', $slot->getName(), $vote->name->{$this->request->getLocale()});
                }
            }

            // Verify that no duplicates exist
            if (count(array_unique($votes)) < count($votes)) {
                return $this->redirectWithError($slotVotes, $globalVotes, 'vote.voting.error.duplicateProject', $slot->getName());
            }

            $allProjects = array_merge($allProjects, $votes);
        }

        if (!isset($globalVotes)) {
            return $this->redirectWithError($slotVotes, $globalVotes, 'vote.voting.error.notGlobalVoted');
        }

        // Verify that no duplicates exist
        if (count(array_unique($globalVotes)) < count($globalVotes)) {
            return $this->redirectWithError($slotVotes, $globalVotes, 'vote.voting.error.globalDuplicateProject');
        }

        // Verify that global projects are also slot-voted
        foreach ($globalVotes as $globalProject) {
            if (!in_array($globalProject, $allProjects)) {
                return $this->redirectWithError($slotVotes, $globalVotes, 'vote.voting.error.notSlotVoted', $globalProject, getProjectById($globalProject)->getName());
            }
        }

        $userId = getCurrentUser()->getId();
        $voteId = 1;

        // Insert slot votes
        foreach ($slots as $slot) {
            $projects = $slotVotes[$slot->getId()];
            foreach ($projects as $projectId) {
                insertVote($userId, $voteId, $projectId);
                $voteId++;
            }
        }

        // Insert global votes
        foreach ($globalVotes as $projectId) {
            insertVote($userId, $voteId, $projectId);
            $voteId++;
        }

        return redirect('/')->with('success', 'vote.voting.success');
    }

    public function redirectWithError($slotVotes, $globalVotes, $error, ...$data): RedirectResponse
    {
        $response = redirect('/')->with('slotVotes', $slotVotes)->with('globalVotes', $globalVotes)->with('error', $error);
        if ($data) {
            $response->with('data', $data);
        }
        return $response;
    }
}