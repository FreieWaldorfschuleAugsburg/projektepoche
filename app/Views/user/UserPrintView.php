<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="text-center">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="10%" height="10%">
            <h1>
                <?= lang('app.name.break') ?>
            </h1>
        </div>
    </div>
</div>
<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="text-center">
            <div class="card mt-3">
                <div class="card-header">
                    <b><?= lang('user.print.guide.headline') ?></b>
                </div>
                <div class="card-body text-start">
                    <h5 class="px-2 underline"><?= lang('user.print.guide.withQR') ?></h5>
                    <ol type="1">
                        <?php foreach (lang('user.print.guide.loginStepsWithQR') as $step): ?>
                            <li><?= $step ?></li>
                        <?php endforeach; ?>
                    </ol>

                    <h5 class="px-2"><?= lang('user.print.guide.withoutQR') ?></h5>
                    <ol type="1">
                        <?php foreach (lang('user.print.guide.loginStepsWithoutQR') as $step): ?>
                            <li><?= $step ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-10">
        <div class="text-center">
            <div class="card mt-3">
                <div class="card-header">
                    <b><?= lang('user.print.credentials.headline') ?></b>

                </div>
                <div class="card-body text-start">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <h6>Benutzername: </h6>
                                <input class="form-control" value="<?= $user->getName() ?>">
                            </div>
                            <div class="mb-3">
                                <h6>Passwort: </h6>
                                <input class="form-control" value="<?= $user->getPassword() ?>">
                            </div>
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center">
                    <img class="w-25" src="<?= $qr ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.print();
        window.onafterprint = function () {
            window.location.href = "/users";
        }
    });
</script>