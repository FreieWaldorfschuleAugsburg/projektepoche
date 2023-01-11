<main id="print" data-bs-theme="light">
    <div class="row gx-4 justify-content-center">
        <div class="col-lg-10">
            <div class="text-center">
                <img src="<?= base_url('/') ?>/assets/img/logo.png" width="10%" height="10%">
                <h1>
                    <?= lang('app.name.break') ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="row gx-4 mt-3 justify-content-center" data-bs-theme="light">
        <div class="col-lg-10">
            <div class="text-center">
                <div class="card mt-3">
                    <div class="card-header">
                        <b><?= lang('user.print.guide.headline') ?></b>
                    </div>
                    <div class="card-body text-start">
                        <h5 class="px-2 underline"><?= lang('user.print.guide.withQR') ?></h5>
                        <ol type="1">
                            <?php foreach (lang('user.print.guide.loginStepsWithQR') as $step): ?>
                                <li><?= $step ?></li>
                            <?php endforeach; ?>
                        </ol>

                        <h5 class="px-2"><?= lang('user.print.guide.withoutQR') ?></h5>
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
                        <b><?= lang('user.print.credentials.headline') ?></b>

                    </div>
                    <div class="card-body text-start">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6>Benutzername: </h6>
                                    <input class="form-control" value="<?= $user->getName() ?>">
                                </div>
                                <div class="mb-3">
                                    <h6>Passwort: </h6>
                                    <input class="form-control" value="<?= $user->getPassword() ?>">
                                </div>
                            </div>
                        </div>
                        <div class="w-100 d-flex justify-content-center" id="qr">
                            <img class="w-25" src="<?= $qr ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div id="userId" hidden><?= $user->getId() ?></div>
            <div id="username" hidden><?= $user->getName() ?></div>
        </div>
    </div>
</main>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    async function generatePdf() {
        console.log("generating");
        window.jsPDF = window.jspdf.jsPDF;
        const element = document.getElementById('print');
        return html2canvas(element).then(async canvas => {
            const data = canvas.toDataURL('image/jpeg');
            const pdf = new jsPDF('P', 'pt', [canvas.width, canvas.height]);
            pdf.addImage(data, 'jpeg', 0, 0, canvas.width, canvas.height);
            const base64Pdf = btoa(pdf.output());
            return await sendPdf(base64Pdf)
        })
    }

    function getUserData() {
        const userId = document.getElementById('userId').innerText
        const userName = document.getElementById('username').innerText
        return {userId, userName}
    }

    async function sendPdf(data) {
        const {userId, userName} = getUserData();
        const body = {
            data: data,
            userId: userId
        }
        const url = '<?=base_url('/api/upload')?>'
        return await fetch(url, {
            method: "POST",
            mode: "cors",
            credentials: "same-origin",
            headers: {
                'Content-Type': "application/json"
            },
            body: JSON.stringify(body)

        })
    }



    document.addEventListener("DOMContentLoaded", async function () {
        await generatePdf().then(() => window.print());
    });

    window.addEventListener('afterprint', function (){
        window.location.href = "/users";
    })


</script>