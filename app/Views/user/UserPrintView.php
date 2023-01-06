<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="text-center">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="20%" height="20%">
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
                <div class="card-body">

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
                <div class="card-body">

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