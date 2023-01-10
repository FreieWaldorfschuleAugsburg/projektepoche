<?php

use App\Entities\Vote;
use App\Models\VoteModel;
use function App\Helpers\getSlots;

enum VoteState: int
{
    case OPEN = 1;
    case CLOSED = 2;
    case PUBLIC = 3;
}

function getVoteState(): VoteState
{
    $state = getSettingsValue("voteState");
    return VoteState::from($state);
}

function setVoteState(VoteState $state)
{
    /**
     * TODO handle state change
     *
     * on OPEN: delete all votes
     * on CLOSED: add all users to the frist slotVote project
     * on PUBLIC: only allow if conflicts are solved
     */
    setSettingsValue("voteState", $state->value);
}

/**
 * @param int $userId
 * @return bool
 */
function hasVoted(int $userId): bool
{
    return getVoteModel()->where(['user_id' => $userId])->countAllResults() > 0;
}

function insertVote(int $userId, int $voteId, int $projectId)
{
    $vote = new Vote();
    $vote->setUserId($userId);
    $vote->setVoteId($voteId);
    $vote->setProjectId($projectId);
    return getVoteModel()->insert($vote);
}

function getSlotVotesAndGlobalVotesByUserId(int $userId): array
{
    $votes = getVotesByUserId($userId);
    $slotVotes = [];
    $globalVotes = [];

    $template = getVoteTemplate();
    $votesPerSlot = count($template->slotVotes);
    $slotCount = count(getSlots());
    $globalVoteStartIndex = ($slotCount * $votesPerSlot) + 1;

    foreach ($votes as $vote) {
        $voteIndex = $vote->getVoteId();
        if ($voteIndex >= $globalVoteStartIndex) {
            $voteId = abs($slotCount * $votesPerSlot - $voteIndex);
            $globalVotes[$voteId] = getProjectById($vote->getProjectId());
        } else {
            $slotId = ceil($voteIndex / $votesPerSlot);
            $voteId = abs(($slotId - 1) * $votesPerSlot - $voteIndex);
            $slotVotes[$slotId][$voteId] = getProjectById($vote->getProjectId());
        }
    }

    return [$slotVotes, $globalVotes];
}

/**
 * @param int $userId
 * @return Vote[]
 */
function getVotesByUserId(int $userId): array
{
    $votes = getVoteModel()->where(['user_id' => $userId])->findAll();
    usort($votes, fn($a, $b) => ($a->getVoteId() - $b->getVoteId()));
    return $votes;
}

function getVoteTemplate(): object
{
    $templateFile = file_get_contents(VOTE_TEMPLATE_CONFIG);
    return json_decode($templateFile);
}

function getVoteModel(): VoteModel
{
    return new VoteModel();
}