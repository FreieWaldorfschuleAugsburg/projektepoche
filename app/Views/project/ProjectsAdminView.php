<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <b><?= lang('project.headline') ?></b>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><?= lang('project.fields.name') ?></th>
                        <th scope="col"><?= lang('project.fields.slot') ?></th>
                        <th scope="col"><?= lang('project.fields.description') ?></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <th><?= $project->getName() ?></th>
                            <td><?= $project->getSlotId() ?></td>
                            <td><?= $project->getDescription() ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>