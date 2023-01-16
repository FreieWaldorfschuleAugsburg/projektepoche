<?php

use App\Entities\User;
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

/**
 * @param int $userId
 * @return Vote[][]
 */
function getVotesByUserId(int $userId): array
{
    $rawVotes = getVoteModel()->where(['user_id' => $userId])->findAll();
    if (!$rawVotes) {
        return [];
    }

    usort($rawVotes, fn($a, $b) => ($a->getVoteId() - $b->getVoteId()));

    $template = getVoteTemplate();
    $slots = getSlots();
    $user = getUserById($userId);

    $votes = [];
    $index = 0;
    foreach ($slots as $slot) {
        if (isSlotBlocked($user, $slot->getId())) {
            continue;
        }

        foreach ($template->votes as $vote) {
            $votes[$slot->getId()][$vote->id] = $rawVotes[$index];
            $index++;
        }
    }

    return $votes;
}

function isSlotBlocked(User $user, int $slotId): bool
{
    $template = getVoteTemplate();
    return isset($template->blockedSlots->{$user->getGroupId()}) && in_array($slotId, $template->blockedSlots->{$user->getGroupId()});
}

function deleteAllVotes(): void
{
    getBuilder(VOTES)->truncate();
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