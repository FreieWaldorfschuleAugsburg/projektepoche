<div class="text-center">
    <h1>Willkommen <?= $user->getName() ?></h1>
    <a class="btn btn-primary btn-lg mt-3 mb-3" data-bs-toggle="collapse" href="#collapsedProjects" role="button"
       aria-expanded="false" aria-controls="collapsedProjects">
        <i class="fas fa-list"></i> <?= lang('vote.buttons.showProjects') ?>
    </a>
</div>

<div class="collapse" id="collapsedProjects">
    <?= view('project/ProjectsUserView') ?>
</div>

<?php if ($user->hasVoted()): ?>
    <!-- show voted projects -->
<?php else: ?>
    <?php if ($voteOpen): ?>
        <!-- show vote form -->
    <?php else: ?>
        <div class="row gx-4 mt-3 justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <b><?= lang('vote.vote.headline') ?></b>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mt-3 justify-content-center text-center">
                            <h1><?= lang('vote.closed.headline') ?></h1>
                            <p><?= lang('vote.closed.details') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>
