<div class="text-center">
    <h1>Willkommen <?= $user->getName() ?></h1>
</div>

<div class="text-center">
    <a class="btn btn-primary btn-lg mt-3 mb-3" data-bs-toggle="collapse" href="#collapsedProjects" role="button"
       aria-expanded="false" aria-controls="collapsedProjects">
        <i class="fas fa-list"></i> <?= lang('vote.buttons.showProjects') ?>
    </a>
</div>

<div class="collapse" id="collapsedProjects">
    <?= view('project/ProjectsUserView') ?>
</div>

<!--<div class="alert alert-danger">
    <b>Achtung! Achtung! Achtung!</b>
    <p>Auch in Zeitschiene 1 musst du drei Angebote wählen, auch wenn du den normalen Unterricht besuchst.<br> <b>Wähle dann:</b><br>
        Unterricht, Dummy1 und Dummy2<br><br>
        <b>Für Photovoltaik wählst du: </b><br>
        Photovoltaik, Dummy1 und Dummy2<br><br>
        <b>Für Photovoltaik und Informatiktag wählst du:</b><br>
        Fotovoltaik, Informatiktag, Dummy1<br><br>
        <b>Qualileute wählen:</b><br>
        Qualivorbereitung, Dummy1 und Dummy2<br>
        (Qualileute wählen auch in den anderen Zeitschienen Quali als ersten Kurs, dann beliebige andere Projekte an zwei und drei.)
    </p>
</div>-->

<?php if ($user->isLeader()): ?>
    <div class="mt-3">
        <?= view('project/ProjectsLeaderView') ?>
    </div>
<?php endif; ?>

<?php if (getVoteState() == VoteState::PUBLIC && $user->mayVote() && $user->hasVoted()): ?>
    <div class="row gx-4 mt-3 justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <b><?= lang('vote.result.headline') ?></b>
                </div>
                <div class="card-body">
                    <p><?= lang('vote.result.details') ?></p>
                    <div class="row gx-4 mt-3 justify-content-center">
                        <?php foreach ($slots as $slot): ?>
                            <div class="col-lg-4 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <b><?= $slot->getName() ?>: <?= $slot->getStartTime() ?>
                                            - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?></b>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isSlotBlocked($user, $slot->getId())): ?>
                                            <div class="alert alert-danger mb-3">
                                                <b><?= lang('vote.voting.blocked') ?></b>
                                            </div>
                                        <?php else: ?>
                                            <?php $project = getProjectByMemberIdAndSlotId($user->getId(), $slot->getId()); ?>
                                            <div class="text-center">
                                                <h4><?= $project->getName() ?></h4>
                                                <hr>
                                                <p><b><?= lang('vote.result.members') ?></b></p>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th><?= lang('user.fields.name') ?></th>
                                                            <th><?= lang('user.fields.grade') ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach ($project->getMembers() as $member): ?>
                                                            <?php if ($member->getId() == $user->getId()) continue; ?>
                                                            <tr>
                                                                <td><?= $member->getName() ?></td>
                                                                <td><?= $member->getGroup()->getName() ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
<?php elseif ($user->mayVote()): ?>
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
                            <?php foreach ($slots as $slot): ?>
                                <div class="col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <b><?= $slot->getName() ?>: <?= $slot->getStartTime() ?>
                                                - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?></b>
                                        </div>
                                        <div class="card-body">
                                            <?php if (isSlotBlocked($user, $slot->getId())): ?>
                                                <div class="alert alert-danger mb-3">
                                                    <b><?= lang('vote.voting.blocked') ?></b>
                                                </div>
                                            <?php else: ?>
                                                <?php foreach ($template->votes as $vote): ?>
                                                    <?php $project = getProjectById($votes[$slot->getId()][$vote->id]->getProjectId()); ?>
                                                    <div class="mb-3">
                                                        <label for="vote-<?= $slot->getId() ?>-<?= $vote->id ?>"
                                                               class="form-label">
                                                            <b><?= $vote->name->{service('request')->getLocale()} ?></b>
                                                        </label>
                                                        <select id="vote-<?= $slot->getId() ?>-<?= $vote->id ?>"
                                                                class="form-select" disabled>
                                                            <option selected>
                                                                <?= $project->getId() ?>
                                                                : <?= $project->getName() ?>
                                                            </option>
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

                            <?= form_open('vote') ?>
                            <p><?= lang('vote.voting.slot.details') ?></p>
                            <div class="row gx-4 mt-3 justify-content-center">
                                <?php $index = 1; ?>
                                <?php foreach ($slots as $slot): ?>
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <b><?= $slot->getName() ?>: <?= $slot->getStartTime() ?>
                                                    - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?></b>
                                            </div>
                                            <div class="card-body">
                                                <?php if (isSlotBlocked($user, $slot->getId())): ?>
                                                    <div class="alert alert-danger mb-3">
                                                        <b><?= lang('vote.voting.blocked') ?></b>
                                                    </div>
                                                    <?php $index += count(getVoteTemplate()->votes); ?>
                                                <?php else: ?>
                                                    <?php foreach ($template->votes as $vote): ?>
                                                        <div class="mb-3">
                                                            <label for="vote-<?= $index ?>"
                                                                   class="form-label">
                                                                <b><?= $vote->name->{service('request')->getLocale()} ?></b>
                                                            </label>
                                                            <select id="vote-<?= $index ?>"
                                                                    name="votes[<?= $index ?>]"
                                                                    class="form-select">
                                                                <option selected
                                                                        disabled><?= lang('vote.voting.select') ?></option>
                                                                <?php foreach (getProjectsBySlotId($slot->getId()) as $project): ?>
                                                                    <?php if (!$project->isSelectable()): continue; endif; ?>
                                                                    <?php if ($votes = session('votes')): ?>
                                                                        <?php if (isset($votes[$index]) && $project->getId() == $votes[$index]): ?>
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
                                                        <?php $index++; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="row gx-4 mt-3 justify-content-center">
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary">
                                        <?= lang('vote.voting.submit') ?>
                                    </button>
                                </div>
                            </div>
                            <?= form_close() ?>
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
<?php endif; ?>