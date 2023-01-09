<?php foreach ($slots as $slot): ?>
    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-header">
                <b><?= $slot->getName() ?>: <?= $slot->getStartTime() ?>
                    - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?></b>
            </div>
            <div class="card-body">
                <?php if (isset($template->blockedSlots->{$user->getGroupId()}) && in_array($slot->getId(), $template->blockedSlots->{$user->getGroupId()})): ?>
                    <div class="alert alert-danger mb-3">
                        <b><?= lang('vote.voting.blocked') ?></b>
                    </div>
                <?php else: ?>
                    <?php foreach ($template->slotVotes as $vote): ?>
                        <?= view('components/vote/SlotVoteComponent', ['slotVotes' => $template->slotVotes, 'vote' => $vote]) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>