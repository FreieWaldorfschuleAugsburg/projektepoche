<?php

use App\Entities\User;
use App\Entities\Vote;
use App\Models\VoteModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use function App\Helpers\getSlots;

enum VoteState: int
{
    case OPEN = 1;
    case CLOSED = 2;
    case PUBLIC = 3;
}

/**
 * @return VoteState
 * @throws DatabaseException
 */
function getVoteState(): VoteState
{
    $state = getSettingsValue("voteState");
    return VoteState::from($state);
}

/**
 * @param VoteState $state
 * @return void
 * @throws DatabaseException
 */
function setVoteState(VoteState $state): void
{
    setSettingsValue("voteState", $state->value);
}

/**
 * @param int $userId
 * @return bool
 * @throws DatabaseException
 */
function hasVoted(int $userId): bool
{
    return getVoteModel()->where(['user_id' => $userId])->countAllResults() > 0;
}

/**
 * @param int $userId
 * @param array $votes
 * @return void
 * @throws DatabaseException|ReflectionException
 */
function insertVotes(int $userId, array $votes): void
{
    $entities = [];
    foreach ($votes as $key => $value) {
        $vote = new Vote();
        $vote->setUserId($userId);
        $vote->setVoteId($key);
        $vote->setProjectId($value);
        $entities[] = $vote;
    }

    getVoteModel()->insertBatch($entities);
}

/**
 * @return void
 * @throws DatabaseException
 */
function deleteAllVotes(): void
{
    getBuilder(VOTES)->truncate();
}

/**
 * @param int $userId
 * @return Vote[][]
 * @throws DatabaseException
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

/**
 * @param User $user
 * @param int $slotId
 * @return bool
 */
function isSlotBlocked(User $user, int $slotId): bool
{
    $template = getVoteTemplate();
    return isset($template->blockedSlots->{$user->getGroupId()}) && in_array($slotId, $template->blockedSlots->{$user->getGroupId()});
}

/**
 * @return object
 */
function getVoteTemplate(): object
{
    $templateFile = file_get_contents(VOTE_TEMPLATE_CONFIG);
    return json_decode($templateFile);
}

/**
 * @return VoteModel
 */
function getVoteModel(): VoteModel
{
    return new VoteModel();
}