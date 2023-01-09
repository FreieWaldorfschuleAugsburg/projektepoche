<div class="mb-3">
    <label for="globalVote-<?= $vote->id ?>" class="form-label">
        <b><?= $vote->name->{service('request')->getLocale()} ?></b>
    </label>
    <select id="globalVote-<?= $vote->id ?>" class="form-select" disabled>
        <option selected>
            <?= $globalVotes[$vote->id]->getId() ?>
            : <?= $globalVotes[$vote->id]->getName() ?>
        </option>
    </select>
</div>