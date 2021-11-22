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
    <?php 
    
    if (session('USER_ID')) {
        echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><i class="fas fa-puzzle-piece"></i> Projektepoche</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <form class="d-flex">
                    <span class="navbar-text"><i class="fas fa-user"></i> ' . session('USER_NAME') . '&nbsp;&nbsp;&nbsp;</span>
                    <a class="btn btn-primary" href="logout"><i class="fas fa-sign-out-alt"></i> Abmelden</a>
                </form>
            </div>
        </div>
    </nav>';
    } else {
        echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="nav navbar-nav mx-auto">
            <a class="navbar-brand" href="/"><i class="fas fa-puzzle-piece"></i> Projektepoche</a>
        </div>
    </nav>';
    }
    
    ?>

    <div class="container px-4 mt-4">