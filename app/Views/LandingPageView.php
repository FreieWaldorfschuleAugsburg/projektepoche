<div class="p-5 mb-4 rounded-3"
     style="background-image: url('<?= base_url('/') ?>/assets/img/banner.webp'); background-position: center center; background-repeat: no-repeat; background-size: cover;">
    <div class="p-5 mb-4 container-fluid bg-body-tertiary py-5 rounded-3">
        <h1 class="display-4 fw-bold">Projektepoche 2024</h1>
        <p class="col-md-8 fs-4">Auch in diesem Jahr findet die Kurswahl für die Projektepoche wieder online
            statt.
            Wähle aus einem vielfältigen Kursangebot deine persönlichen Favoriten aus!</p>
        <a class="btn btn-primary btn-lg" type="button" href="<?= base_url('login') ?>">Jetzt anmelden &
            abstimmen!</a>
    </div>
</div>


<?= view('project/ProjectsUserView') ?>