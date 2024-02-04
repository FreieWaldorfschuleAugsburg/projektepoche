<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <b><?= lang('project.leading.title') ?></b>
            </div>
            <div class="card-body">
                <div class="accordion accordion-flush" id="ownProjects">
                    <?php foreach (getCurrentUser()->getOwnProjects() as $project): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-<?= $project->getId() ?>">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse-<?= $project->getId() ?>">
                                    <b><?= $project->getName() ?></b>
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse-<?= $project->getId() ?>"
                                 data-bs-parent="#ownProjects">
                                <div class="accordion-body">

                                    <b>
                                        <i class="fas fa-user"></i> <?= lang('project.view.leader') ?>:
                                        <?= $project->getLeaderShortNameString() ?><br/>
                                        <i class="fas fa-people-group"></i> <?= lang('project.view.maxMembers') ?>:
                                        <?= $project->getCapacity() ?>
                                        <?php if (!empty($project->getRoom())): ?>
                                            <br/><i class="fas fa-door-closed"></i> <?= lang('project.view.room') ?>:
                                            <?= $project->getRoom() ?>
                                        <?php endif; ?>
                                    </b>
                                    <hr>
                                    <p class="mt-3">
                                        <?= $project->getDescription() ?>
                                    </p>
                                    <hr>
                                    <?php if (getVoteState() == VoteState::PUBLIC): ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered"
                                                   data-locale="<?= service('request')->getLocale(); ?>"
                                                   data-toggle="table" data-search="true" data-height="300"
                                                   data-pagination="true"
                                                   data-show-columns="true" data-cookie="true"
                                                   data-cookie-id-table="leader-<?= $project->getId() ?>"
                                                   data-search-highlight="true"
                                                   data-show-columns-toggle-all="true">
                                                <thead>
                                                <tr>
                                                    <th data-field="name" data-sortable="true"
                                                        scope="col"><?= lang('user.fields.name') ?></th>
                                                    <th data-field="group" data-sortable="true"
                                                        scope="col"><?= lang('user.fields.grade') ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($project->getMembers() as $user): ?>
                                                    <tr>
                                                        <td id="td-id-<?= $user->getId() ?>"
                                                            class="td-class-<?= $user->getId() ?>"
                                                            data-title="<?= $user->getName() ?>"><?= $user->getName() ?></td>
                                                        <td><?= $user->getGroup()->getName() ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-danger">
                                            <i class="fas fa-triangle-exclamation"></i> <?= lang('project.leading.notPublic') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
