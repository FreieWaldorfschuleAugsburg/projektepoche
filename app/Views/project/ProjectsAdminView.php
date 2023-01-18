<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('project.headline') ?></b>
                <a class="btn btn-primary btn-sm"
                   href="<?= base_url('project/create') ?>"><i
                            class="fas fa-add"></i> <?= lang('project.buttons.create') ?></a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" data-locale="<?= service('request')->getLocale(); ?>"
                       data-toggle="table" data-search="true" data-height="1000" data-pagination="true"
                       data-show-columns="true" data-search-highlight="true" data-show-columns-toggle-all="true">
                    <thead>
                    <tr>
                        <th data-field="name" data-sortable="true"><?= lang('project.fields.name') ?></th>
                        <th data-field="slot" data-sortable="true"><?= lang('project.fields.slot') ?></th>
                        <th data-field="maxMembers" data-sortable="true"><?= lang('project.fields.maxMembers') ?></th>
                        <th data-field="room" data-sortable="true"><?= lang('project.fields.room') ?></th>
                        <th data-field="leaders" data-sortable="true"><?= lang('project.fields.leaders') ?></th>
                        <th data-field="members" data-sortable="true"><?= lang('project.fields.members') ?></th>
                        <th data-field="conflict" data-sortable="true"><?= lang('project.fields.conflict.title') ?></th>
                        <th data-field="action"><?= lang('project.fields.actions.title') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr id="tr-id-<?= $project->getId() ?>"
                            class="tr-class-<?= $project->getId() ?> <?= $project->hasConflict() ? 'table-danger' : '' ?>">
                            <td id="td-id-<?= $project->getId() ?>" class="td-class-<?= $project->getId() ?>"
                                data-title="<?= $project->getName() ?>"><?= $project->getName() ?>
                            </td>
                            <td><?= $project->getSlotId() ?></td>
                            <td><?= $project->getMaxMembers() ?></td>
                            <td><?= $project->getRoom() ?></td>
                            <td><?= $project->getLeaderShortNameString() ?></td>
                            <td><?= count($project->getMembers()) ?></td>
                            <td><?= $project->hasConflict() ? lang('project.fields.conflict.yes') : lang('project.fields.conflict.no') ?></td>
                            <td>
                                <div class="btn-group d-flex gap-2">
                                    <a class="btn btn-success btn-sm"
                                       href="<?= base_url('project/redistribute') . '?id=' . $project->getId() ?>"><i
                                                class="fas fa-arrows-split-up-and-left"></i> <?= lang('project.fields.actions.redistribute') ?>
                                    </a>
                                    <a class="btn btn-primary btn-sm"
                                       href="<?= base_url('project/edit') . '?id=' . $project->getId() ?>"><i
                                                class="fas fa-pen"></i> <?= lang('project.fields.actions.edit') ?></a>
                                    <a class="btn btn-danger btn-sm delete"
                                       href="<?= base_url('project/delete') . '?id=' . $project->getId() ?>"><i
                                                class="fas fa-trash"></i> <?= lang('project.fields.actions.delete') ?>
                                    </a>
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

<script>
    const confirmDelete = (event => {
        if (!confirm("Möchten Sie den Benutzer wirklich löschen?")) {
            event.preventDefault();
        }
    })
    window.onload = function () {
        document.querySelectorAll('.delete').forEach(element => {
            element.addEventListener("click", confirmDelete, true)
        })
    }
</script>