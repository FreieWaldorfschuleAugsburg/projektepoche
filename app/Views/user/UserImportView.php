<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <b><?= lang('user.import.headline') ?></b>
                <a class="btn btn-primary btn-sm"
                   href="<?= base_url('users') ?>"><i
                            class="fas fa-backward"></i> <?= lang('user.buttons.back') ?></a>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> <?= lang('user.import.desc') ?>
                </div>
                <form action="<?= base_url('user/edit') ?>" method="post">
                    <button type="submit" class="btn btn-primary"><?= lang('user.edit.button') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>