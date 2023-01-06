<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('user.headline') ?></b>
                <a class="btn btn-primary btn-sm"
                   href="<?= base_url('users') ?>"><i
                            class="fas fa-backward"></i> <?= lang('user.buttons.back') ?></a>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="username" class="form-label"><?= lang('user.fields.name') ?></label>
                        <input type="text" class="form-control" id="username" value="<?= $user->getName() ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><?= lang('user.fields.password') ?></label>
                        <input type="text" class="form-control" id="password" value="<?= $user->getPassword() ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><?= lang('user.fields.group') ?></label>
                        <select class="form-control" id="group">
                            <?php foreach ($groups as $group): ?>
                                <?php if($group->getId() === $user->getGroupId()): ?>
                                    <option value="<?= $group->getId() ?>" selected><?= $group->getName() ?></option>
                                <?php else: ?>
                                    <option value="<?= $group->getId() ?>"><?= $group->getName() ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= lang('user.edit.button') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>