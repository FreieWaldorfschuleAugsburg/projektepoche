<?php if (isset($project)): ?>
    <div class="card mt-3">
        <div class="card-body">
            <h4><?= $project->getName() ?></h4>
            <span><?= $project->getDescription() ?></span>
        </div>
    </div>
<?php endif; ?>