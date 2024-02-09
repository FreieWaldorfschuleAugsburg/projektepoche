<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('user.create.headline') ?></b>
                <a class="btn btn-primary btn-sm"
                   href="<?= base_url('users') ?>"><i
                            class="fas fa-backward"></i> <?= lang('user.buttons.back') ?></a>
            </div>
            <div class="card-body">
                <?= form_open('user/create') ?>
                <div class="mb-3">
                    <label for="name" class="form-label"><?= lang('user.fields.name') ?></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><?= lang('user.fields.password') ?></label>
                    <input type="text" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="group" class="form-label"><?= lang('user.fields.group') ?></label>
                    <select class="form-control" id="group" name="group" required>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?= $group->getId() ?>"><?= $group->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><?= lang('user.create.button') ?></button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>