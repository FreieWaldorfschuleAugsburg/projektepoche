<?php use function App\Helpers\getSlots;

foreach (getSlots() as $slot): ?>
    <div class="row gx-4 mt-3 justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <b><?= $slot->getName() ?>: <?= $slot->getStartTime() ?>
                        - <?= $slot->getEndTime() ?> <?= lang('project.view.clock') ?></b>
                </div>
                <div class="card-body">
                    <div class="accordion accordion-flush" id="slot-<?= $slot->getId() ?>">
                        <?php foreach (getProjectsBySlotId($slot->getId()) as $project): ?>
                            <?php if (!$project->isSelectable()): continue; endif; ?>

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

                                        <b>
                                            <i class="fas fa-user"></i> <?= lang('project.view.leader') ?>:
                                            <?= $project->getLeaderShortNameString() ?><br/>
                                            <i class="fas fa-people-group"></i> <?= lang('project.view.maxMembers') ?>:
                                            <?= $project->getMaxMembers() ?>
                                            <?php if (!empty($project->getRoom())): ?>
                                                <br/>
                                                <i class="fas fa-door-closed"></i> <?= lang('project.view.room') ?>:
                                                <?= $project->getRoom() ?>
                                            <?php endif; ?>
                                        </b>
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