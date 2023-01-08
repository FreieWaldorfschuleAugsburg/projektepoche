<?php

use App\Entities\Vote;
use App\Models\VoteModel;

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
 * @return Vote[]
 */
function getVotesByUserId(int $userId): array
{
    return getVoteModel()->where(['user_id' => $userId])->findAll();
}

function getVoteModel(): VoteModel
{
    return new VoteModel();
}