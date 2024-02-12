<main id="print">
    <div class="row gx-4 mt-3 justify-content-center text-body bg-body" id="width">
        <div class="col-lg-10">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="80" height="80" style="float: right">

            <h1><u><?= $project->getName() ?></u></h1>
            <p>&nbsp;&nbsp;&nbsp;<?= ($slot = $project->getSlot())->getName() ?> (<?= $slot->getStartTime() ?>
                - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?>)
                <br>&nbsp;&nbsp;&nbsp;<b><?= lang('project.fields.leaders') ?>:</b> <?= $project->getLeaderShortNameString() ?>
                <br>&nbsp;&nbsp;&nbsp;<b><?= lang('project.fields.room') ?>:</b> <?= $project->getRoom() ?></p>
            <hr>

            <div class="card mt-3">
                <div class="card-header">
                    <b class="text-body"><?= lang('project.print.members.title') ?></b>
                </div>
                <div class="card-body text-start">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th><?= lang('user.fields.name') ?></th>
                                <th><?= lang('user.fields.grade') ?></th>
                                <!--<?php for ($i = 1; $i <= getSettingsValue('days'); $i++): ?>
                                    <?php
                                    $time = strtotime(getSettingsValue('startDay') . ' + ' . ($i - 1) . ' days');
                                    $date = date('d.m.', $time);
                                    $day = date('w', $time);
                                    ?>
                                    <?php if ($day != 0 && $day != 6): ?>
                                        <th class="text-center" style="font-size: 8px"><?= $date ?></th>
                                    <?php endif; ?>
                                <?php endfor; ?>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($project->getMembers() as $member): ?>
                                <tr>
                                    <td><?= $member->getName() ?></td>
                                    <td><?= $member->getGroup()->getName() ?></td>
                                    <!--<?php for ($i = 1; $i <= getSettingsValue('days'); $i++): ?>
                                        <?php
                                        $time = strtotime(getSettingsValue('startDay') . ' + ' . ($i - 1) . ' days');
                                        $date = date('d.m.', $time);
                                        $day = date('w', $time);
                                        ?>
                                        <?php if ($day != 0 && $day != 6): ?>
                                            <td></td>
                                        <?php endif; ?>
                                    <?php endfor; ?>-->
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <small><?= lang('project.print.members.description') ?></small>
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