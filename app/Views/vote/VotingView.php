<?php

use function App\Helpers\getSlots;

?>
<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('vote.headline') ?></b>
                <div class="justify-content-between align-items-center">
                    <?php if (getVoteState() == VoteState::OPEN): ?>
                        <a class="btn btn-danger btn-sm"
                           href="<?= base_url('voting/state') . '?id=2' ?>"><i
                                    class="fas fa-lock"></i> <?= lang('vote.buttons.state.close') ?></a>
                    <?php elseif (getVoteState() == VoteState::CLOSED): ?>
                        <a class="btn btn-success btn-sm"
                           href="<?= base_url('voting/state') . '?id=1' ?>"><i
                                    class="fas fa-lock-open"></i> <?= lang('vote.buttons.state.open') ?></a>
                        <a class="btn btn-primary btn-sm"
                           href="<?= base_url('voting/assign') ?>"><i
                                    class="fas fa-folder-tree"></i> <?= lang('vote.buttons.assign') ?></a>
                        <a class="btn btn-primary btn-sm"
                           href="<?= base_url('voting/state') . '?id=3' ?>"><i
                                    class="fas fa-bullhorn"></i> <?= lang('vote.buttons.state.public') ?></a>
                    <?php elseif (getVoteState() == VoteState::PUBLIC): ?>
                        <a class="btn btn-danger btn-sm"
                           href="<?= base_url('voting/reset') ?>"><i
                                    class="fas fa-bullhorn"></i> <?= lang('vote.buttons.reset') ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" data-locale="<?= service('request')->getLocale(); ?>"
                       data-toggle="table" data-search="true" data-height="1000" data-pagination="true"
                       data-show-columns="true" data-cookie="true" data-cookie-id-table="vote"
                       data-search-highlight="true" data-show-columns-toggle-all="true">
                    <thead>
                    <tr>
                        <th data-field="name" data-sortable="true"
                            scope="col"><?= lang('vote.fields.name') ?></th>
                        <?php $voteId = 0; ?>
                        <?php foreach (getSlots() as $slot): ?>
                            <?php foreach (getVoteTemplate()->votes as $vote): ?>
                                <th data-field="votes-<?= $voteId ?>" data-sortable="true"
                                    scope="col"><?= $slot->getName() . '/' . $vote->name->{service('request')->getLocale()} ?></th>
                                <?php $voteId++; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (getUsers() as $user):
                        if (!$user->mayVote()): continue; endif;
                        $votes = getVotesByUserId($user->getId()); ?>
                        <tr>
                            <td><?= $user->getName() ?></td>
                            <?php foreach (getSlots() as $slot): ?>
                                <?php if (!isset($votes[$slot->getId()])): ?>
                                    <?php foreach (getVoteTemplate()->votes as $vote): ?>
                                        <td><?= lang('vote.votes.noData') ?></td>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach ($votes[$slot->getId()] as $vote): ?>
                                        <td>
                                            <b><?= $vote->getProjectId() ?></b>: <?= getProjectById($vote->getProjectId())->getName() ?>
                                        </td>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>