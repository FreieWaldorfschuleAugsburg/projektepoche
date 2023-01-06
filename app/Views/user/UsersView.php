<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <?php if ($error = session('error')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-triangle-exclamation"></i> <?= $error ?>
        </div>
        <?php endif; ?>

        <?php if ($success = session('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= $success ?>
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
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" data-locale="<?= service('request')->getLocale(); ?>"
                       data-toggle="table" data-search="true" data-height="580" data-pagination="true"
                       data-show-columns="true" data-search-highlight="true" data-show-columns-toggle-all="true">
                    <thead>
                    <tr>
                        <th data-field="name" data-sortable="true" scope="col"><?= lang('user.fields.name') ?></th>
                        <th data-field="password" scope="col"><?= lang('user.fields.password') ?></th>
                        <th data-field="group" data-sortable="true" scope="col"><?= lang('user.fields.group') ?></th>
                        <th data-field="vote" scope="col"><?= lang('user.fields.vote.title') ?></th>
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
                            <td><?= $user->hasVoted() ? lang('user.fields.vote.value.yes') : lang('user.fields.vote.value.no') ?></td>
                            <td><a class="btn btn-primary btn-sm"
                                   href="<?= base_url('user/print') . '?id=' . $user->getId() ?>"><i
                                            class="fas fa-print"></i> <?= lang('user.fields.actions.print') ?></a>
                                <a class="btn btn-primary btn-sm"
                                   href="<?= base_url('user/edit') . '?id=' . $user->getId() ?>"><i
                                            class="fas fa-pen"></i> <?= lang('user.fields.actions.edit') ?></a>
                                <a class="btn btn-danger btn-sm"
                                   href="<?= base_url('user/delete') . '?id=' . $user->getId() ?>"><i
                                            class="fas fa-trash"></i> <?= lang('user.fields.actions.delete') ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>