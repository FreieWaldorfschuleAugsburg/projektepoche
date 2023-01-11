<?php

use App\Exceptions\HasNoProjectsException;

?>
<div>
   <h2> <?=lang('user.leader.headline')?></h2>
    <?php try {
        foreach (getProjectsForLeader(getCurrentUser()->getId()) as $project): ?>
            <?= view('components/card/ProjectCard', ['project' => $project]) ?>
        <?php endforeach;
    } catch (HasNoProjectsException $e) {
    } ?>
</div>