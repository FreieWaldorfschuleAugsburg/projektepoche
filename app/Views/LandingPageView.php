<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <b>Informationen</b>
            </div>
            <div class="card-body">
                <h5>Projektepoche</h5>
                <p>Vom 5. bis 18. März, also in den zwei Wochen nach den Faschingsferien, wird der normale Stundenplan
                    ausgesetzt und die Projektepoche stattfinden.
                    In drei Zeitschienen werden verschiedenste Kurse angeboten. Gelb unterlegt sind die praktischen und
                    künstlerischen Kurse, blau die theoretischen Kurse.
                    In diesen zwei Wochen werdet ihr also nicht den normalen Unterricht haben, sondern je nach
                    Interesse entweder 2 blaue und 1 gelben Kurs oder 1 blauen und 2 gelbe.
                </p>

                <h5>Kursauswahl</h5>
                <p>Von <b>Mittwoch bis einschließlich Freitag (24. - 26.11.)</b> könnt Ihr die Kurse wählen.
                    Da viele Kurse eine Teilnehmerbegrenzung haben, gebt Ihr für jede Zeitschiene eine 1., 2.
                    und 3. Wahl an - also insgesamt 9 Kurse – wobei unter diesen mindestens 3 blaue und 3 gelbe sein
                    sollen - die weiteren 3 sind ganz frei wählbar.
                    Zusätzlich könnt Ihr den Kurs, der euch der allerwichtigste ist, und auch den
                    zweitwichtigsten angeben.
                    <br><br>
                    Die Wahl kann online stattfinden. Melde dich dazu unten mit den dir bekannten Daten an.
                    Wer lieber auf Papier wählen möchte, nehme sich einen Wahlzettel an den Stellwänden im Roten Haus
                    und gebe ihn - ans EWG adressiert - im Lehrerzimmer ab.<br><br>
                    <b>Wir wünschen viel Freude beim Wählen und hoffen, dass für jeden etwas Interessantes dabei
                        ist.</b>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <b>Anmeldung</b>
            </div>
            <div class="card-body">
                <p>Melde dich hier mit deinen Zugangsdaten an!</p>
                <?php if(session('error')) { echo '<div class="alert alert-danger">' . lang(session('error')) . '</div>'; } ?>
                <form action="login" method="POST">
                    <div class="row g-3">
                        <div class="col">
                            <input type="text" class="form-control" name="name" placeholder="Vor- und Nachname" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="accessToken" placeholder="Zugangscode" required>
                        </div>
                    </div>
                    <br>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Anmelden</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
foreach ($data as $item) {

    echo '<div class="row gx-4 mt-3 justify-content-center"><div class="col-lg-10">
    <div class="card"><div class="card-header"><b>Zeitschiene ' . $item['slot']->id . ':</b> ' . convert($item['slot']->start_time) . ' - ' . convert($item['slot']->end_time) . ' Uhr</div>
    <div class="card-body"><div class="accordion accordion-flush" id="SLOT'. $item['slot']->id .'">';

    foreach ($item['projects'] as $project) {
        echo '<div class="accordion-item">
        <h2 class="accordion-header" id="heading'. $project['handle']->id . '">
            <button class="accordion-button collapsed; rounded" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse'. $project['handle']->id . '" aria-expanded="false" aria-controls="collapse'. $project['handle']->id . '"
                style="' . ($project['handle']->color === 'BLUE' ? 'background-color:#506AD4; color:white' : 'background-color:#FAEB8D; color:#102A42') . '" ;>
                <b>'. $project['handle']->name . '</b>
            </button>
        </h2>
        <div id="collapse'. $project['handle']->id . '" class="accordion-collapse collapse" aria-labelledby="heading'. $project['handle']->id . '"
            data-bs-parent="#SLOT'. $item['slot']->id .'">
            <div class="accordion-body">
                <i class="fas fa-user"></i>
                &nbsp;<b>Kursleitung: <i>' . join(', ', $project['teachers']) . '</i></b>
                <hr><br>'. $project['handle']->description . '
            </div>
        </div>
    </div>';
    }

    echo '</div></div></div></div></div>';
}

function convert($input) {
    return substr($input, 0, strlen($input) - 3);
}
?>