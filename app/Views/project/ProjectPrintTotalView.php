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
            <h1><u><?= lang('project.print.total.title') ?></u></h1>
            <hr>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center"><?= lang('user.fields.name') ?></th>
                        <?php foreach (($slots = \App\Helpers\getSlots()) as $slot): ?>
                            <th class="text-center"><?= $slot->getName() ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php if (!$user->mayVote() || !$user->hasVoted()) continue; ?>
                        <tr>
                            <td><?= $user->getName() ?></td>
                            <?php foreach ($slots as $slot): ?>
                                <?php if (isSlotBlocked($user, $slot->getId())): ?>
                                    <td><?= lang('project.print.total.blocked') ?></td>
                                <?php else: ?>
                                    <td><?= getProjectByMemberIdAndSlotId($user->getId(), $slot->getId())->getName() ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
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