<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('conflict.headline') ?></b>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" data-locale="<?= service('request')->getLocale(); ?>"
                       data-toggle="table" data-search="true" data-height="580" data-pagination="true"
                       data-show-columns="true" data-search-highlight="true" data-show-columns-toggle-all="true">
                    <thead>
                    <tr>
                        <th data-field="name" data-sortable="true"><?= lang('project.fields.name') ?></th>
                        <th data-field="slot" data-sortable="true"><?= lang('project.fields.slot') ?></th>
                        <th data-field="maxMembers" data-sortable="true"><?= lang('project.fields.maxMembers') ?></th>
                        <th data-field="room" data-sortable="true"><?= lang('project.fields.room') ?></th>
                        <th data-field="leaders" data-sortable="true"><?= lang('project.fields.leaders') ?></th>
                        <th data-field="members" data-sortable="true"><?= lang('project.fields.members') ?></th>
                        <th data-field="description"><?= lang('project.fields.description') ?></th>
                        <th data-field="action"><?= lang('project.fields.actions.title') ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>