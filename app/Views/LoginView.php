<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <b>Anmelden</b>
            </div>
            <div class="card-body">
                <form method="POST">
                    <?= session('error') ? '<div class="alert alert-danger mb-3">' . session('error') . '</div>' : '' ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Vor- und Nachname</label>
                        <input class="form-control" id="name" name="name" aria-describedby="nameHelp" value="<?= session('name') ? session('name') : '' ?>" required>
                        <div id="nameHelp" class="form-text">Bitte achte auf richtige Schreibweise! (z.B. bei Doppelnamen)</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Passwort</label>
                        <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" required>
                        <div id="passwordHelp" class="form-text">Das Passwort hast du von deinem Klassenbetreuer erhalten!</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Anmelden</button>
                </form>
            </div>
        </div>
    </div>
</div>