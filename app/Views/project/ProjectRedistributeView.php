<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('project.redistribute.headline') ?></b>
                <a class="btn btn-primary btn-sm"
                   href="<?= base_url('projects') ?>"><i
                            class="fas fa-backward"></i> <?= lang('project.buttons.back') ?></a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label"><?= lang('project.fields.name') ?></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $project->getName() ?>"
                           disabled>
                </div>

                <div class="mb-3">
                    <label for="slot" class="form-label"><?= lang('project.fields.slot') ?></label>
                    <input type="text" class="form-control" id="slot" name="slot"
                           value="<?= \App\Helpers\getSlotById($project->getSlotId())->getName() ?>"
                           disabled>
                </div>

                <div class="mb-3">
                    <label for="maxMembers" class="form-label"><?= lang('project.fields.maxMembers') ?></label>
                    <input type="number" class="form-control" id="maxMembers" name="maxMembers" min="1"
                           value="<?= $project->getMaxMembers() ?>" disabled>
                </div>

                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered"
                           data-locale="<?= service('request')->getLocale(); ?>"
                           data-toggle="table" data-search="true" data-height="580" data-pagination="true"
                           data-cookie="true" data-cookie-id-table="redistribute-<?= $project->getId() ?>"
                           data-show-columns="true" data-search-highlight="true" data-show-columns-toggle-all="true">
                        <thead>
                        <tr>
                            <th data-field="name"
                                data-sortable="true"><?= lang('project.redistribute.fields.name') ?></th>
                            <th data-field="action"><?= lang('project.redistribute.fields.actions.title') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($project->getMembers() as $member): ?>
                            <tr id="tr-id-<?= $member->getId() ?>" class="tr-class-<?= $member->getId() ?>">
                                <td id="td-id-<?= $member->getId() ?>"
                                    class="td-class-<?= $member->getId() ?> <?= $count > $project->getMaxMembers() ? 'table-danger' : '' ?>"
                                    data-title=" <?= $member->getName() ?>"><?= $member->getName() ?>
                                </td>
                                <td>
                                    <div class="btn-group d-flex gap-2">
                                        <?php
                                        $voteId = 0;
                                        foreach (getVotesByUserId($member->getId())[$project->getSlotId()] as $vote): ?>
                                            <?php if (($newProject = getProjectById($vote->getProjectId()))->getId() != $project->getId()): ?>
                                                <a class="btn btn-primary btn-sm"
                                                   href="<?= base_url('project/move') ?>?user=<?= $member->getId() ?>&slot=<?= $project->getSlotId() ?>&project=<?= $project->getId() ?>&newProject=<?= $newProject->getId() ?>"><i
                                                            class="fas fa-arrows-split-up-and-left"></i> <?= getVoteTemplate()->votes[$voteId]->name->{service('request')->getLocale()} ?>
                                                    <br/> <?= lang('project.redistribute.fields.actions.auto') ?>
                                                    <b><?= $newProject->getId() ?>: <?= $newProject->getName() ?>
                                                        (<?= count($newProject->getMembers()) ?>
                                                        / <?= $newProject->getMaxMembers() ?>)</b>
                                                </a>
                                            <?php endif; ?>
                                            <?php $voteId++; ?>
                                        <?php endforeach; ?>
                                        <div class="vr"></div>
                                        <?= form_open('project/move', 'method="get"') ?>
                                        <input type="hidden" name="user" value="<?= $member->getId() ?>">
                                        <input type="hidden" name="slot" value="<?= $project->getSlotId() ?>">
                                        <input type="hidden" name="project" value="<?= $project->getId() ?>">

                                        <label for="newProject"
                                               class="form-label"><?= lang('project.redistribute.fields.actions.manual') ?></label>
                                        <select class="form-control mb-3" id="newProject" name="newProject"
                                                required>
                                            <option selected
                                                    disabled><?= lang('vote.voting.select') ?></option>
                                            <?php foreach (getProjectsBySlotId($project->getSlotId()) as $newProject): ?>
                                                <?php if ($newProject->getId() != $project->getId()): ?>
                                                    <option value="<?= $newProject->getId() ?>"><?= $newProject->getId() ?>
                                                        : <?= $newProject->getName() ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit"
                                                class="btn btn-primary"><?= lang('project.redistribute.buttons.submit') ?></button>
                                        <?= form_close() ?>
                                    </div>
                                </td>
                            </tr>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>