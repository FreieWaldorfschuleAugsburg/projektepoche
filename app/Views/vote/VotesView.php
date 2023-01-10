<?php

use function App\Helpers\getSlots;

?>
<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <b><?= lang('vote.headline') ?></b>
                <div class="justify-content-between align-items-center">
                    <a class="btn btn-primary btn-sm"
                       href="<?= base_url('vote/export') ?>"><i
                                class="fas fa-download"></i> <?= lang('vote.buttons.export') ?></a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" data-locale="<?= service('request')->getLocale(); ?>"
                       data-toggle="table" data-search="true" data-height="580" data-pagination="true"
                       data-show-columns="true" data-search-highlight="true" data-show-columns-toggle-all="true">
                    <thead>
                    <tr>
                        <th data-field="name" data-sortable="true"
                            scope="col"><?= lang('vote.fields.name') ?></th>
                        <?php foreach (getSlots() as $slot): ?>
                            <?php foreach (getVoteTemplate()->slotVotes as $vote): ?>
                                <th data-field="slotVotes-<?= $slot->getId() ?>-<?= $vote->id ?>" data-sortable="true"
                                    scope="col"><?= $slot->getName() . '/' . $vote->name->{service('request')->getLocale()} ?></th>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <?php foreach (getVoteTemplate()->globalVotes as $vote): ?>
                            <th data-field="globalVotes-<?= $vote->id ?>" data-sortable="true"
                                scope="col"><?= $vote->name->{service('request')->getLocale()} ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (getUsers() as $user): ?>
                        <tr>
                            <td><?= $user->getName() ?></td>
                            <?php foreach (getVotesByUserId($user->getId()) as $vote): ?>
                                <td>
                                    <b><?= $vote->getProjectId() ?></b>: <?= getProjectById($vote->getProjectId())->getName() ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>