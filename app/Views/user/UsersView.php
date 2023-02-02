<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <?php if ($error = session('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-triangle-exclamation"></i> <?= lang($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success = session('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= lang($success) ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('user.headline') ?></b>
                <div class="justify-content-between align-items-center">
                    <a class="btn btn-primary btn-sm"
                       href="<?= base_url('user/create') ?>"><i
                                class="fas fa-add"></i> <?= lang('user.buttons.create') ?></a>
                    <a class="btn btn-primary btn-sm"
                       href="<?= base_url('user/import') ?>"><i
                                class="fas fa-upload"></i> <?= lang('user.buttons.import') ?></a>

                    <a class="btn btn-success btn-sm"
                       href="<?= base_url('users/print/all/credentials') ?>"><i
                                class="fas fa-download"></i> <?= lang('user.buttons.downloadCredentials') ?></a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" data-locale="<?= service('request')->getLocale(); ?>"
                       data-toggle="table" data-search="true" data-height="1000" data-pagination="true"
                       data-show-columns="true" data-cookie="true" data-cookie-id-table="user"
                       data-search-highlight="true" data-show-columns-toggle-all="true">
                    <thead>
                    <tr>
                        <th data-field="name" data-sortable="true" scope="col"><?= lang('user.fields.name') ?></th>
                        <th data-field="password" scope="col"><?= lang('user.fields.password') ?></th>
                        <th data-field="group" data-sortable="true" scope="col"><?= lang('user.fields.group') ?></th>
                        <th data-field="vote" data-sortable="true"
                            scope="col"><?= lang('user.fields.vote.title') ?></th>
                        <?php if (getVoteState() == VoteState::CLOSED): ?>
                            <?php foreach (\App\Helpers\getSlots() as $slot): ?>
                                <th data-field="<?= $slot->getId() ?>" scope="col"><?= $slot->getName() ?></th>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <th data-field="action" scope="col"><?= lang('user.fields.actions.title') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td id="td-id-<?= $user->getId() ?>" class="td-class-<?= $user->getId() ?>"
                                data-title="<?= $user->getName() ?>"><?= $user->getName() ?></td>
                            <td><?= $user->getPassword() ?></td>
                            <td><?= $user->getGroup()->getName() ?></td>
                            <td><?= !$user->mayVote() ? lang('user.fields.vote.value.notVoting') : ($user->hasVoted() ? lang('user.fields.vote.value.yes') : lang('user.fields.vote.value.no')) ?></td>
                            <?php if (getVoteState() == VoteState::CLOSED): ?>
                                <?php foreach (\App\Helpers\getSlots() as $slot): ?>
                                    <td>
                                        <?php if ($user->mayVote() && $user->hasVoted()): ?>
                                            <?php $project = getProjectByMemberIdAndSlotId($user->getId(), $slot->getId()); ?>
                                            <?= is_null($project) ? lang('vote.votes.noData') : $project->getName() ?>
                                        <?php else: ?>
                                            <?= lang('vote.votes.noData') ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <td>
                                <div class="btn-group d-flex gap-2" role="group">
                                    <a class="btn btn-success btn-sm"
                                       href="<?= base_url('user/print/credentials') . '?id=' . $user->getId() ?>"><i
                                                class="fas fa-key"></i></a>
                                    <?php if ($user->mayVote() && $user->hasVoted()): ?>
                                        <a class="btn btn-success btn-sm"
                                           href="<?= base_url('user/print/projects') . '?id=' . $user->getId() ?>"><i
                                                    class="fas fa-puzzle-piece"></i></a>
                                    <?php endif; ?>
                                    <a class="btn btn-primary btn-sm"
                                       href="<?= base_url('user/edit') . '?id=' . $user->getId() ?>"><i
                                                class="fas fa-pen"></i></a>
                                    <a class="btn btn-danger btn-sm delete"
                                       href="<?= base_url('user/delete') . '?id=' . $user->getId() ?>"><i
                                                class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const confirmDelete = (event => {
        if (!confirm("Möchten Sie den Benutzer wirklich löschen?")) {
            event.preventDefault();
        }
    })


    window.onload = function () {
        document.querySelectorAll('.delete').forEach(element => {
            element.addEventListener("click", confirmDelete, true)
        })
    }
</script>