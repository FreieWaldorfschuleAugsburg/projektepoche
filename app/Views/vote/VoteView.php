<div class="text-center" xmlns="http://www.w3.org/1999/html">
    <h1>Willkommen <?= $user->getName() ?></h1>
    <a class="btn btn-primary btn-lg mt-3 mb-3" data-bs-toggle="collapse" href="#collapsedProjects" role="button"
       aria-expanded="false" aria-controls="collapsedProjects">
        <i class="fas fa-list"></i> <?= lang('vote.buttons.showProjects') ?>
    </a>
</div>

<div class="collapse" id="collapsedProjects">
    <?= view('project/ProjectsUserView') ?>
</div>

<?php if ($success = session('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?= lang($success) ?>
    </div>
<?php endif; ?>

<?php if ($user->hasVoted()): ?>
    <div class="row gx-4 mt-3 justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <b><?= lang('vote.voting.headline') ?></b>
                </div>
                <div class="card-body">
                    <p><?= lang('vote.voting.slot.details') ?></p>
                    <div class="row gx-4 mt-3 justify-content-center">
                        <?= view('components/vote/SlotsWithProjectComponent', ['slots' => $slots, 'user' => $user]) ?>
                    </div>
                    <div class="row gx-4 mt-3 justify-content-center">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <b><?= lang('vote.voting.global.headline') ?></b>
                                </div>
                                <div class="card-body">
                                    <p><?= lang('vote.voting.global.details') ?></p>
                                    <?php foreach ($template->globalVotes as $vote): ?>
                                        <?= view('components/vote/GlobalVoteComponent', ['globalVotes' => $template->$globalVotes, 'vote' => $vote]) ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-4 mt-3 justify-content-center">
                        <div class="col-sm-2">
                            <a href="mailto:ewg@waldorf-augsburg.de" class="btn btn-danger">
                                <i class="fas fa-gavel"></i> <?= lang('vote.voting.reportError') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php if (getVoteState() == VoteState::OPEN): ?>
        <div class="row gx-4 mt-3 justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <b><?= lang('vote.voting.headline') ?></b>
                    </div>
                    <div class="card-body">
                        <?php if ($error = session('error')): ?>
                            <div class="alert alert-danger">
                                <?php if ($data = session('data')): ?>
                                    <i class="fas fa-triangle-exclamation"></i> <?= sprintf(lang($error), ...$data) ?>
                                <?php else: ?>
                                    <i class="fas fa-triangle-exclamation"></i> <?= lang($error) ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('/vote') ?>" method="POST">
                            <p><?= lang('vote.voting.slot.details') ?></p>
                            <div class="row gx-4 mt-3 justify-content-center">
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
                                                        <div class="mb-3">
                                                            <label for="slotVote-<?= $slot->getId() ?>-<?= $vote->id ?>"
                                                                   class="form-label">
                                                                <b><?= $vote->name->{service('request')->getLocale()} ?></b>
                                                            </label>
                                                            <select id="slotVote-<?= $slot->getId() ?>-<?= $vote->id ?>"
                                                                    name="slotVotes[<?= $slot->getId() ?>][<?= $vote->id ?>]"
                                                                    class="form-select">
                                                                <option selected
                                                                        disabled><?= lang('vote.voting.select') ?></option>
                                                                <?php foreach (getProjectsBySlotId($slot->getId()) as $project): ?>
                                                                    <?php if ($slotVotes = session('slotVotes')): ?>
                                                                        <?php if (isset($slotVotes[$slot->getId()]) && isset($slotVotes[$slot->getId()][$vote->id]) && $project->getId() == $slotVotes[$slot->getId()][$vote->id]): ?>
                                                                            <option value="<?= $project->getId() ?>"
                                                                                    selected>
                                                                                <?= $project->getId() ?>
                                                                                : <?= $project->getName() ?>
                                                                            </option>
                                                                        <?php else: ?>
                                                                            <option value="<?= $project->getId() ?>">
                                                                                <?= $project->getId() ?>
                                                                                : <?= $project->getName() ?>
                                                                            </option>
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <option value="<?= $project->getId() ?>">
                                                                            <?= $project->getId() ?>
                                                                            : <?= $project->getName() ?>
                                                                        </option>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="row gx-4 mt-3 justify-content-center">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <b><?= lang('vote.voting.global.headline') ?></b>
                                        </div>
                                        <div class="card-body">
                                            <p><?= lang('vote.voting.global.details') ?></p>
                                            <?php foreach ($template->globalVotes as $vote): ?>
                                                <div class="mb-3">
                                                    <label for="globalVote-<?= $vote->id ?>" class="form-label">
                                                        <b><?= $vote->name->{service('request')->getLocale()} ?></b>
                                                    </label>
                                                    <select id="globalVote-<?= $vote->id ?>"
                                                            name="globalVotes[<?= $vote->id ?>]" class="form-select">
                                                        <option selected
                                                                disabled><?= lang('vote.voting.select') ?></option>
                                                        <?php foreach (getProjects() as $project): ?>
                                                            <?php if ($globalVotes = session('globalVotes')): ?>
                                                                <?php if (isset($globalVotes[$vote->id]) && $project->getId() == $globalVotes[$vote->id]): ?>
                                                                    <option value="<?= $project->getId() ?>"
                                                                            selected>
                                                                        <?= $project->getId() ?>
                                                                        : <?= $project->getName() ?>
                                                                    </option>
                                                                <?php else: ?>
                                                                    <option value="<?= $project->getId() ?>">
                                                                        <?= $project->getId() ?>
                                                                        : <?= $project->getName() ?>
                                                                    </option>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <option value="<?= $project->getId() ?>">
                                                                    <?= $project->getId() ?>
                                                                    : <?= $project->getName() ?>
                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row gx-4 mt-3 justify-content-center">
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary">
                                        <?= lang('vote.voting.submit') ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row gx-4 mt-3 justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <b><?= lang('vote.voting.headline') ?></b>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mt-3 justify-content-center text-center">
                            <h1><?= lang('vote.closed.headline') ?></h1>
                            <p><?= lang('vote.closed.details') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>
