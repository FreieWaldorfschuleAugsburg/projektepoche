<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
    <title></title>
    <style>
        <?= file_get_contents("./assets/css/boostrap-3.min.css"); ?>
        <?= file_get_contents("./assets/css/style.css"); ?>
        <?= file_get_contents("./assets/css/fontawesome.min.css"); ?>
        <?= file_get_contents("./assets/css/bootstrap-table.min.css"); ?>
        .test {
            font-family: 'Montserrat', sans-serif;
        }
    </style>

</head>


<body style="background-color: white">
<div class="justify-content-center">
    <div class="col-lg-10">
        <div class="text-center">
            <h2>
                <?= lang('app.name.break') ?>
            </h2>
        </div>
    </div>
</div>
<div class="mr-3 row mt-3 text-left justify-content-center text-body bg-body">
    <div class="col-lg-10">
        <div class="">
            <div class="card mt-3">
                <div class="card-header">
                    <b><?= lang('user.print.guide.headline') ?></b>
                </div>
                <div class="card-body text-start">
                    <h5 class="px-2 underline text-body"><?= lang('user.print.guide.withQR') ?></h5>
                    <ol type="1">
                        <?php foreach (lang('user.print.guide.loginStepsWithQR') as $step): ?>
                            <li><?= $step ?></li>
                        <?php endforeach; ?>
                    </ol>

                    <h5 class="px-2 text-body"><?= lang('user.print.guide.withoutQR') ?></h5>
                    <ol type="1">
                        <?php foreach (lang('user.print.guide.loginStepsWithoutQR') as $step): ?>
                            <li><?= $step ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-10">
        <div class="text-center">
            <div class="card mt-3">
                <div class="card-header">
                    <b class="text-body"><?= lang('user.print.credentials.headline') ?></b>
                </div>
                <div class="card-body text-start">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-body">Benutzername: </h6>
                                <p class="border px-2 rounded-3 py-2 card-header card" ><?=$username?></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-body">Passwort: </h6>
                                <p class="border px-2 rounded-3 py-2 card-header card" ><?=$password?></p>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center" id="qr">
                        <img class="w-25" src="<?= $qr ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>