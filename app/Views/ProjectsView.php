<?php if (isset($data)): ?>
    <?php foreach ($data as $slotWithProject): ?>
        <main>
            <div class="row gx-4 mt-3 justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <b><?= $slotWithProject['slot']->getName() ?>
                                (<?= $slotWithProject['slot']->getStartTime() ?>
                                - <?= $slotWithProject['slot']->getEndTime() ?>)</b>
                        </div>
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="slot-<?= $slotWithProject['slot']->getId() ?>">

                                <?php foreach ($slotWithProject['projects'] as $project): ?>
                                    <section>
                                        <h2 class="accordion-header" id="heading-<?= $project['handle']->getId() ?>">
                                            <button class="accordion-button collapsed; rounded" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse<?= $project['handle']->getId() ?>"
                                                    aria-controls="collapse<?= $project['handle']->getId() ?>">
                                                <b><?= $project['handle']->getName() ?></b>
                                            </button>
                                        </h2>
                                        <div id="collapse<?= $project['handle']->getId() ?>"
                                             class="accordion-collapse collapse"
                                             aria-labelledby="heading-<?= $project['handle']->getId() ?>"
                                             data-bs-parent="#slot<?= $slotWithProject['slot']->getId() ?>">
                                            <div class="accordion-body">
                                                <i class="fas fa-user"></i>
                                                <b>
                                                    <?= lang('project.leader') . " " . join(",", $project['teachers']) ?>
                                                </b>
                                                <p><?= $project['handle']->getDescription() ?></p>
                                            </div>
                                        </div>
                                    </section>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <?php endforeach; ?>
<?php endif; ?>
