<center class="mb-5">
    <h1>Willkommen <?= getCurrentUser()->getName() ?></h1>
    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
        aria-controls="collapseExample">
        <i class="fas fa-list-alt"></i> Alle Kurse anzeigen
    </a>
</center>

<div class="collapse" id="collapseExample">
    <?= view('ProjectsView') ?>
</div>

<div class="row gx-4 mt-3 justify-content-center" <?= $mayVote && $voteOpen ? '' : 'hidden' ?>>
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <b>Kurswahl</b>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/vote') ?>" method="POST">
                    <?= session('error') ? '<div class="alert alert-danger mb-3">' . session('error') . '</div>' : '' ?>
                    <p>
                        Wähle pro Zeitschiene drei Kurse in absteigender Priorität.
                    </p>
                    <div class="row gx-4 mt-3 justify-content-center">
                        <?php
                    foreach($data as $item){
                        echo '<div class="col-lg-4 mb-3"><div class="card"><div class="card-header"><b>Zeitschiene ' . $item['slot']->id . ':</b> ' . convert($item['slot']->start_time) . ' - ' . convert($item['slot']->end_time) . ' Uhr</div>
                              <div class="card-body">';
                        
                        if($item['slot']->id == 1 && getCurrentUser()->getGroupId() == 4) {
                            echo '<div class="alert alert-danger mb-3">' . '<b>Blockiert!</b> Eurythmieabschluss.' . '</div>';
                        } else {
                            for ($i=1; $i <= 3; $i++) {
                                echo '<div class="mb-3"><label for="disabledSelect" class="form-label"><b>'. $i . '. Wahl</b></label><select id="S'. $item['slot']->id . 'V'. $i .'" name="S'. $item['slot']->id . 'V'. $i .'" class="form-select">';
                                echo '<option value="0" selected disabled>Bitte wählen...</option>';
                                foreach($item['projects'] as $project) {
                                    echo '<option value="'. $project['handle']->id . '"' . (isSelected($item['slot']->id, $i, $project['handle']->id) ? 'selected' : '') . '>' . $project['handle']->id . ': ' . $project['handle']->name . '</option>';
                                }
                                echo '</select></div>';
                            }
                        }
                        echo '</div></div></div>';
                    }

                    function isSelected($slotId, $voteId, $projectId) {
                        $inputData = session('inputData');
                        if ($inputData == null) return false;

                        if (array_key_exists($slotId, $inputData)) {
                            $slotData = $inputData[$slotId];
                            if (array_key_exists($voteId, $slotData)) {
                                return $slotData[$voteId] == $projectId;
                            }
                        }
                    }
                    ?>
                    </div>

                    <div class="row gx-4 mt-3 justify-content-center">
                        <div class="col-lg-10">
                            <div class="card">
                                <div class="card-header">
                                    <b>Priorisierung</b>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Wähle abschließend die zwei wichtigsten Kurse!
                                    </p>
                                    <div class="mb-3">
                                        <label for="disabledSelect" class="form-label"><b>Wichtigster Kurs</b></label>
                                        <select id="TOP1" name="TOP1" class="form-select">
                                            <option value="0" selected disabled>Bitte wählen...</option>
                                            <?php
                                            foreach($data as $item){
                                                foreach($item['projects'] as $project) {
                                                    echo '<option value="'. $project['handle']->id . '" ' . (isSelected(4, 1, $project['handle']->id) ? 'selected' : '') . '>' . $project['handle']->id . ': ' . $project['handle']->name . '</option>';
                                                }
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="disabledSelect" class="form-label"><b>Zweit-wichtigster
                                                Kurs</b></label>
                                        <select id="TOP2" name="TOP2" class="form-select">
                                            <option value="0" selected disabled>Bitte wählen...</option>
                                            <?php
                                            foreach($data as $item){
                                                foreach($item['projects'] as $project) {
                                                    echo '<option value="'. $project['handle']->id . '"' . (isSelected(4, 2, $project['handle']->id) ? 'selected' : '') . '>' . $project['handle']->id . ': ' . $project['handle']->name . '</option>';
                                                }
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-4 mt-3 justify-content-center">
                        <div class="col-sm-2">
                            <input type="submit" class="btn btn-primary" value="Absenden" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row gx-4 mt-3 justify-content-center" <?= $voteOpen || !$mayVote ? 'hidden' : '' ?>>
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <b>Deine Kurswahl</b>
            </div>
            <div class="card-body">
                <div class="row gx-4 mt-3 justify-content-center text-center">
                    <h1>Wahl geschlossen!</h1>
                    <p>Die Wahl hat noch nicht begonnen, oder wurde bereits beendet.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row gx-4 mt-3 justify-content-center" <?= $mayVote ? 'hidden' : '' ?>>
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <b>Deine Kurswahl</b>
            </div>
            <div class="card-body">
                <div class="row gx-4 mt-3 justify-content-center text-center">
                    <?php
                    if (!$mayVote) {
                        for ($slotId = 1; $slotId <= count($votes)-1; $slotId++) { 
                            $voteData = $votes[$slotId];
    
                            echo '<div class="col-lg-4 mb-3"><div class="card"><div class="card-header"><b>Zeitschiene ' . $slotId. '</b></div>
                                  <div class="card-body">';
                            
                            if($slotId == 1 && getCurrentUser()->getGroupId() == 4) {
                                    echo '<div class="alert alert-danger mb-3">' . '<b>Blockiert!</b> Eurythmieabschluss.' . '</div>';
                                } else {
                                    for ($voteId = 1; $voteId <= count($voteData); $voteId++) {
                                        $vote = $voteData[$voteId];
            
                                        echo '<div class="mb-3"><label for="disabledSelect" class="form-label"><b>'. $voteId . '. Wahl</b></label><select class="form-select" disabled>';
                                        echo '<option selected>'. $vote['project']->id . ': ' . $vote['project']->name . '</option>';
                                        echo '</select></div>';
                                    }
                                }
                            echo '</div></div></div>';
                        }
                    }
                    ?>
                </div>
                <div class="row gx-4 mt-3 justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                                <b>Priorisierung</b>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="disabledSelect" class="form-label"><b>Wichtigster Kurs</b></label>
                                    <select class="form-select" disabled>
                                        <?php
                                            if (!$mayVote) echo '<option selected>' . $votes[4][1]['project']->id . ': ' . $votes[4][1]['project']->name . '</option>';
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="disabledSelect" class="form-label"><b>Zweit-wichtigster
                                            Kurs</b></label>
                                    <select class="form-select" disabled>
                                        <?php
                                            if (!$mayVote) echo '<option selected>' . $votes[4][2]['project']->id . ': ' . $votes[4][2]['project']->name . '</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <a href="mailto:uwe.henken@waldorf-augsburg.de" class="btn btn-danger"><i
                                class="fas fa-gavel"></i> Fehler melden</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
function convert($input): string
{
    return substr($input, 0, strlen($input) - 3);
}
?>