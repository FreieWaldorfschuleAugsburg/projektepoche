<div class="row gx-4 mt-3 justify-content-center">

    <center>
        <img class="mb-4" src="/img/favicon.png" alt="Logo" height="64" width="64">
        <h1>Kurswahl der Projektepoche</h1>
        <hr>
        <p>Liebe/r Schüler/in! Du erhältst nun deine Zugangsdaten für die Kurswahl der Projektepoche. <br>Bitte beachte, dass diese Zugangsdaten
            <b>nur
                dir</b> bekannt sein dürfen!
        </p>
    </center>
    <hr>
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                Deine Zugangsdaten
            </div>
            <div class="card-body text-center">
                <h4>Benutzername: <?= $project->getName() ?></h4>
                <h4>Passwort: <?= $project->getPassword() ?></h4>
            </div>
        </div>
    </div>

    <center>
        <br><br>
        <p><b>Wichtig! Bitte wähle möglichst zeitnah!</b><br>Wir benötigen alle Schülerstimmen um ggf. Tausch- und Umdisponierungsvorgänge zu klären!
        </p>
    </center>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(event) {
    window.print();

    window.onafterprint = function() {
        window.location.href = "/users";
    }
});
</script>