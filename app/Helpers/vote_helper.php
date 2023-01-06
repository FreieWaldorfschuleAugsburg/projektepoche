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