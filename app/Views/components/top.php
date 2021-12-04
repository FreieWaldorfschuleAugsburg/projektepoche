<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Projektepoche</title>

    <link rel="icon" type="image/x-icon" href="<?= base_url('/') ?>/img/favicon.png" />
    <link href="<?= base_url('/') ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>/css/fontawesome/css/all.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" <?= session('noNav') ? 'hidden' : '' ?>>
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>"><i class="fas fa-puzzle-piece"></i> Projektepoche</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobileToggle"
                aria-controls="navbarMobileToggle" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMobileToggle">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown" <?= session('GROUP') && session('GROUP')->admin ? '' : 'hidden' ?>>
                        <a class="nav-link dropdown-toggle" href="#" id="Submenu-Dropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-tachometer-alt"></i> Administration
                        </a>
                        <ul class="dropdown-menu rounded-3" aria-labelledby="Submenu-Dropdown">
                            <li><a class="dropdown-item" href="<?= base_url('/users') ?>"><i class="fas fa-users"></i> Nutzerverwaltung</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('/votes') ?>"><i class="fas fa-poll"></i> Stimmverwaltung</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="btn-group float-end">
                    <a href="<?= base_url(session('USER') ? 'logout' : 'login') ?>"
                        class="text-decoration-none text-light">
                        <?= session('USER') ? '<i class="fas fa-sign-out-alt"></i> Abmelden' : '<i class="fas fa-sign-in-alt"></i> Anmelden' ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container px-4 mt-4">