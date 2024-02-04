<main id="print">
    <div class="row gx-4 mt-3 justify-content-center text-body bg-body" id="width">
        <div class="col-lg-10">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="80" height="80" style="float: right">

            <h1><u><?= $project->getName() ?></u></h1>
            <p>&nbsp;&nbsp;&nbsp;<?= ($slot = $project->getSlot())->getName() ?> (<?= $slot->getStartTime() ?>
                - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?>)</p>
            <hr>

            <div class="card mt-3">
                <div class="card-header">
                    <b class="text-body"><?= lang('project.print.info') ?></b>
                </div>
                <div class="card-body text-start">
                    <div class="mb-3">
                        <h6 class="text-body"><?= lang('project.print.fields.leaders') ?> </h6>
                        <input class="form-control" value="<?= $project->getLeaderShortNameString() ?>">
                    </div>
                    <div class="mb-3">
                        <h6 class="text-body"><?= lang('project.print.fields.room') ?> </h6>
                        <input class="form-control" value="<?= $project->getRoom() ?>">
                    </div>
                    <div class="mb-3">
                        <h6 class="text-body"><?= lang('project.print.fields.maxMembers') ?> </h6>
                        <input class="form-control" value="<?= $project->getCapacity() ?>">
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <b class="text-body"><?= lang('project.fields.description') ?></b>
                </div>
                <div class="card-body text-start">
                    <div class="mb-3">
                        <?= $project->getDescription() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    document.addEventListener("DOMContentLoaded", async function () {
        document.querySelector("html").setAttribute("data-bs-theme", "light");
        window.print();
    });
    window.addEventListener('afterprint', function () {
        window.location.href = "/projects";
    })
</script>