<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <b><?= lang('user.headline') ?></b>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><?= lang('user.fields.name') ?></th>
                        <th scope="col"><?= lang('user.fields.password') ?></th>
                        <th scope="col"><?= lang('user.fields.group') ?></th>
                        <th scope="col"><?= lang('user.fields.vote.title') ?></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <th><?= $user->getName() ?></th>
                            <td><?= $user->getPassword() ?></td>
                            <td><?= $user->getGroup()->getName() ?></td>
                            <td><?= $user->hasVoted() ? lang('user.fields.vote.value.yes') : lang('user.fields.vote.value.no') ?></td>
                            <td><a class="btn btn-primary btn-sm"
                                   href="<?= base_url('user/print') . '?id=' . $user->getId() ?>"><i
                                            class="fas fa-print"></i> <?= lang('user.fields.action.print') ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>