<style>
    tr {
        line-height: 10px;
        min-height: 10px;
        height: 10px;
    }
</style>

<main id="print">
    <div class="row gx-4 mt-3 justify-content-center text-body bg-body" id="width">
        <div class="col-lg-12 mt-3">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="60" height="60" style="float: right">
            <h1><u><?= lang('project.print.overview.title') ?></u></h1>
            <hr>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center"><?= lang('project.fields.name') ?></th>
                        <th class="text-center"><?= lang('project.fields.slot') ?></th>
                        <th class="text-center"><?= lang('project.fields.leaders') ?></th>
                        <th class="text-center"><?= lang('project.fields.room') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($projects as $project): ?>
                        <?php if (!$project->isVisible()): continue; endif; ?>
                        <tr>
                            <td><?= $project->getName() ?></td>
                            <td><?= ($slot = $project->getSlot())->getName() ?> (<?= $slot->getStartTime() ?>
                                - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?>)
                            </td>
                            <td><?= $project->getLeaderShortNameString() ?></td>
                            <td><?= $project->getRoom() ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
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