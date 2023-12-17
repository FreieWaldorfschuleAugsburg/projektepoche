<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('project.create.headline') ?></b>
                <a class="btn btn-primary btn-sm"
                   href="<?= base_url('projects') ?>"><i
                            class="fas fa-backward"></i> <?= lang('project.buttons.back') ?></a>
            </div>
            <div class="card-body">
                <?= form_open('project/create') ?>
                    <div class="mb-3">
                        <label for="name" class="form-label"><?= lang('project.fields.name') ?></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="slot" class="form-label"><?= lang('project.fields.slot') ?></label>
                        <select class="form-control" id="slot" name="slot" required>
                            <?php foreach ($slots as $slot): ?>
                                <option value="<?= $slot->getId() ?>"><?= $slot->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="maxMembers" class="form-label"><?= lang('project.fields.maxMembers') ?></label>
                        <input type="number" class="form-control" id="maxMembers" name="maxMembers" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="room" class="form-label"><?= lang('project.fields.room') ?></label>
                        <input type="text" class="form-control" id="room" name="room">
                    </div>
                    <div class="mb-3">
                        <label for="leaders" class="form-label"><?= lang('project.fields.leaders') ?></label>
                        <select class="form-control" id="leaders" name="leaders[]" multiple required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user->getId() ?>"><?= $user->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="members" class="form-label"><?= lang('project.fields.members') ?></label>
                        <select class="form-control" id="members" name="members[]" multiple>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user->getId() ?>"><?= $user->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label"><?= lang('project.fields.description') ?></label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <label for="selectable"
                               class="form-check-label"><?= lang('project.fields.selectable.title') ?></label>
                        <input type="checkbox" class="form-check-input" id="selectable" name="selectable" value="on"
                               checked>
                    </div>

                    <button type="submit" class="btn btn-primary"><?= lang('project.create.button') ?></button>
                    <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#description').summernote();
        // Fix for summernote cuz dropdowns broken in BS5
        $("button[data-toggle='dropdown']").each(function (index) {
            $(this).removeAttr("data-toggle").attr("data-bs-toggle", "dropdown");
        });
    });
</script>