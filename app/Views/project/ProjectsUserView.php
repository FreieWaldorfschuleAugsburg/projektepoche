<?php use function App\Helpers\getSlots;

foreach (getSlots() as $slot): ?>
    <div class="row gx-4 mt-3 justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <b><?= $slot->getName() ?>: <?= $slot->getStartTime() ?>
                        - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?></b>
                </div>
                <div class="card-body">
                    <div class="accordion accordion-flush" id="slot-<?= $slot->getId() ?>">
                        <?php foreach (getProjectsBySlotId($slot->getId()) as $project): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-<?= $project->getId() ?>">
                                    <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-<?= $project->getId() ?>">
                                        <b><?= $project->getName() ?></b>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="collapse-<?= $project->getId() ?>"
                                     data-bs-parent="#slot-<?= $slot->getId() ?>">
                                    <div class="accordion-body">
                                        <i class="fas fa-user"></i> <b><?= lang('project.view.leader') ?>:
                                            <?= $project->getLeaderShortNameString() ?></b>
                                        <hr>
                                        <p class="mt-3">
                                            <?= $project->getDescription() ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>