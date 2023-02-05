<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <?php if ($error = session('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-triangle-exclamation"></i> <?= lang($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success = session('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= lang($success) ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('slot.headline') ?></b>
                <div class="justify-content-between align-items-center">
                    <a class="btn btn-primary btn-sm"
                       href="<?= base_url('slot/create') ?>"><i
                                class="fas fa-add"></i> <?= lang('slot.buttons.create') ?></a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" data-locale="<?= service('request')->getLocale(); ?>"
                       data-toggle="table" data-search="true" data-height="1000" data-pagination="true"
                       data-show-columns="true" data-cookie="true" data-cookie-id-table="user"
                       data-search-highlight="true" data-show-columns-toggle-all="true">
                    <thead>
                    <tr>
                        <th data-field="name" data-sortable="true" scope="col"><?= lang('slot.fields.name') ?></th>
                        <th data-field="action" scope="col"><?= lang('slot.fields.actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($slots as $slot): ?>
                        <tr>
                            <td id="td-id-<?= $slot->getId() ?>" class="td-class-<?= $slot->getId() ?>"
                                data-title="<?= $slot->getName() ?>"><?= $slot->getName() ?></td>
                            <td>
                                <div class="btn-group d-flex gap-2" role="group">
                                    <a class="btn btn-primary btn-sm"
                                       href="<?= base_url('slot/edit') . '?id=' . $slot->getId() ?>"><i
                                                class="fas fa-pen"></i></a>
                                    <a class="btn btn-danger btn-sm delete"
                                       href="<?= base_url('slot/delete') . '?id=' . $slot->getId() ?>"><i
                                                class="fas fa-trash"></i></a>
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