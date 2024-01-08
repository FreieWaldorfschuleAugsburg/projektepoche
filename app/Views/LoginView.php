<main>
    <div class="container login">
        <div class="card login">
            <div class="card-header">
                <b><?= lang('login.headline') ?></b>
            </div>
            <div class="card-body">
                <?= form_open() ?>
                <?php if ($error = session('error')): ?>
                    <div class="alert alert-danger mb-3">
                        <i class="fas fa-triangle-exclamation"></i> <?= lang($error) ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="name" class="form-label"><?= lang('login.fields.name') ?></label>
                    <input class="form-control" id="name" name="name" aria-describedby="nameHelp"
                           value="<?= session('name') ? session('name') : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><?= lang('login.fields.password') ?></label>
                    <input type="password" class="form-control" id="password" name="password"
                           aria-describedby="passwordHelp" required>
                </div>
                <button type="submit" class="btn btn-primary"><?= lang('login.buttons.login') ?></button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</main>