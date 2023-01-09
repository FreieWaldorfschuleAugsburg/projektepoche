<div class="mb-3">
    <label for="slotVote-<?= $slot->getId() ?>-<?= $vote->id ?>"
           class="form-label">
        <b><?= $vote->name->{service('request')->getLocale()} ?></b>
    </label>
    <select id="slotVote-<?= $slot->getId() ?>-<?= $vote->id ?>"
            class="form-select" disabled>
        <option selected>
            <?= $slotVotes[$slot->getId()][$vote->id]->getId() ?>
            : <?= $slotVotes[$slot->getId()][$vote->id]->getName() ?>
        </option>
    </select>
</div>