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

                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered"
                           data-locale="<?= service('request')->getLocale(); ?>"
                           data-toggle="table" data-search="true" data-height="580" data-pagination="true"
                           data-show-columns="true" data-search-highlight="true" data-show-columns-toggle-all="true">
                        <thead>
                        <tr>
                            <th data-field="name"
                                data-sortable="true"><?= lang('project.redistribute.fields.name') ?></th>
                            <th data-field="action"><?= lang('project.redistribute.fields.actions.title') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($project->getMembers() as $member): ?>
                            <tr id="tr-id-<?= $member->getId() ?>" class="tr-class-<?= $member->getId() ?>">
                                <td id="td-id-<?= $member->getId() ?>" class="td-class-<?= $member->getId() ?>"
                                    data-title="<?= $member->getName() ?>"><?= $member->getName() ?>
                                </td>
                                <td>
                                    <div class="btn-group d-flex gap-2">
                                        <?php
                                        foreach (getVotesByUserId($member->getId())[$project->getSlotId()] as $vote):
                                            $newProject = getProjectById($vote->getProjectId());
                                            ?>
                                            <a class="btn btn-primary btn-sm"
                                               href="<?= base_url('project/move') ?>?user=<?= $member->getId() ?>&slot=<?= $project->getSlotId() ?>&projectId=<?= $newProject->getId() ?>"><i
                                                        class="fas fa-arrows-split-up-and-left"></i> <?= lang('project.redistribute.fields.actions.auto') ?>
                                                <b><?= getProjectById($vote->getProjectId())->getName() ?>
                                                    (<?= count($newProject->getMembers()) ?>
                                                    / <?= $newProject->getMaxMembers() ?>)</b>
                                            </a>
                                        <?php endforeach; ?>
                                        <div class="vr"></div>
                                        <form>
                                            <label for="slot"
                                                   class="form-label"><?= lang('project.redistribute.fields.actions.manual') ?></label>
                                            <select class="form-control mb-3" id="slot" name="slot" required>
                                                <option selected
                                                        disabled><?= lang('vote.voting.select') ?></option>
                                                <?php foreach (getProjectsBySlotId($project->getSlotId()) as $newProject): ?>
                                                    <option value="<?= $newProject->getId() ?>"><?= $newProject->getId() ?>
                                                        : <?= $newProject->getName() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit"
                                                    class="btn btn-primary"><?= lang('project.redistribute.buttons.submit') ?></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>