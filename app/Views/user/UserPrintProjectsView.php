<main id="print">
    <div class="row gx-4 justify-content-center">
        <div class="col-lg-10">
            <div class="text-center">
                <img src="<?= base_url('/') ?>/assets/img/logo.png" width="10%" height="10%">
                <h1 class="text-body">
                    <?= lang('app.name.break') ?>
                </h1>
                <br/>

                <h2><?= lang('user.print.projects') ?></h2>
                <h3><?= $user->getName() ?></h3>
            </div>
        </div>
    </div>
    <div class="row gx-4 mt-3 justify-content-center text-body bg-body" id="width">
        <?php foreach (\App\Helpers\getSlots() as $slot): ?>
            <div class="col-sm-1 mt-3">
                <div class="card">
                    <div class="card-header">
                        <b><?= $slot->getName() ?>: <?= $slot->getStartTime() ?>
                            - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?></b>
                    </div>
                    <div class="card-body">
                        <?php if (isSlotBlocked($user, $slot->getId())): ?>
                            <div class="alert alert-danger mb-3">
                                <b><?= lang('vote.voting.blocked') ?></b>
                            </div>
                        <?php else: ?>
                            <?php $project = getProjectByMemberIdAndSlotId($user->getId(), $slot->getId()); ?>
                            <div class="text-center">
                                <h4><?= $project->getName() ?></h4>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<script>
    document.addEventListener("DOMContentLoaded", async function () {
        document.querySelector("html").setAttribute("data-bs-theme", "light");
        window.print();
    });
    window.addEventListener('afterprint', function () {
        window.location.href = "/users";
    })
</script>