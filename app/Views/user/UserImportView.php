<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <?php if ($error = session('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-triangle-exclamation"></i> <?= lang($error) ?>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('user.import.headline') ?></b>
                <a class="btn btn-primary btn-sm"
                   href="<?= base_url('users') ?>"><i
                            class="fas fa-backward"></i> <?= lang('user.buttons.back') ?></a>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> <?= lang('user.import.desc') ?>
                </div>
                <?php if (isset($users)): ?>
                    <?= form_open('user/import') ?>
                    <div class="d-flex justify-content-between align-items- py-2">
                        <h5>Importierte Benutzer</h5>
                        <button type="submit" name="intent" value="confirm"
                                class="btn btn-success"><?= lang('user.import.save') ?></button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped"
                               data-locale="<?= service('request')->getLocale(); ?>"
                               data-toggle="table" data-search="false" data-height="auto" data-pagination="false"
                               data-show-columns="false" data-search-highlight="true"
                               data-show-columns-toggle-all="true">

                            <thead>
                            <tr>
                                <th data-field="name" data-sortable="true" class="p-2"
                                    scope="col"><?= lang('user.fields.name') ?></th>
                                <th data-field="password" class="p-2"
                                    scope="col"><?= lang('user.fields.password') ?></th>
                                <th data-field="group" data-sortable="true" class="p-2"
                                    scope="col"><?= lang('user.fields.group') ?></th>
                            </tr>
                            </thead>
                            <tbody class="mt-5">
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td id="td-id-<?= $user->getId() ?>" class="td-class-<?= $user->getId() ?>"
                                        data-title="<?= $user->getName() ?>"><input class="form-control"
                                                                                    name="username[]" id="username[]"
                                                                                    value="<?= $user->getName() ?>">
                                    </td>
                                    <td><input name="password[]" class="form-control"
                                               value="<?= $user->getPassword() ?>">
                                    </td>
                                    <td><input name="groupName[]" class="form-control"
                                               value="<?= $user->getGroup()->getName() ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                    <?= form_close() ?>
                <?php endif; ?>

                <?php if (isset($errors)): ?>
                    <h5>Fehlerhafte Benutzer</h5>
                    <div class="table-responsive">
                        <table class="table table-striped"
                               data-locale="<?= service('request')->getLocale(); ?>"
                               data-toggle="table" data-search="false" data-height="auto" data-pagination="true"
                               data-show-columns="false" data-search-highlight="true"
                               data-show-columns-toggle-all="true">
                            <thead>
                            <tr>
                                <th data-field="name" data-sortable="true" class="p-2"
                                    scope="col"><?= lang('user.fields.name') ?></th>
                                <th data-field="error" data-sortable="true" class="p-2"
                                    scope="col"><?= lang('user.fields.name') ?></th>
                            </tr>
                            </thead>
                            <tbody class="mt-5">
                            <?php foreach ($errors as $error): ?>
                                <tr>
                                    <td id="td-id-<?= $error['user']['name'] ?>"
                                        class="td-class-<?= $error['user']['name'] ?>"
                                        data-title="<?= $error['user']['name'] ?>"><?= $error['user']['name'] ?></td>
                                    <td><?= $error['cause'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                <div class="mt-2">
                    <?= form_open_multipart('user/import') ?>
                    <div class="mb-3">
                        <label for="keys_firstName" class="form-label"><?= lang('user.fields.firstName') ?></label>
                        <input type="text" class="form-control" id="keys_firstName" name="keys_firstName"
                               value="Vorname" required>
                    </div>
                    <div class="mb-3">
                        <label for="keys_lastName" class="form-label"><?= lang('user.fields.lastName') ?></label>
                        <input type="text" class="form-control" id="keys_lastName" name="keys_lastName"
                               value="Nachname" required>
                    </div>
                    <div class="mb-3">
                        <label for="keys_grade" class="form-label"><?= lang('user.fields.grade') ?></label>
                        <input type="text" class="form-control" id="keys_grade" name="keys_grade" value="Klasse"
                               required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" required type="file" id="userUploadFile"
                               name="userUploadFile">
                    </div>
                    <button type="submit" name="intent" value="import"
                            class="btn btn-primary"><?= lang('user.import.button') ?></button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>