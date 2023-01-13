<div class="card mt-3">
    <div class="card-header">
        <h5><?= lang('credentials.headline') ?></h5>
    </div>
    <div class="card-body d-flex flex-column w-100 align-items-center">
        <div id="loading">
            <div class="d-flex flex-column w-100 align-items-center">
                <p><?= lang('credentials.status.loading') ?></p>
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div id="loaded" hidden="hidden">
            <div class="d-flex flex-column w-100 align-items-center">
                <p><?= lang('credentials.status.loaded') ?></p>
                <p>(created in <span id="time">10</span> seconds)</p>
                <button class="btn btn-primary" id="downloadButton"><?= lang('credentials.status.button') ?></button>
            </div>
        </div>

    </div>
</div>


<main id="print" data-bs-theme="light" style="opacity: 0;">
    <div class="row gx-4 justify-content-center">
        <div class="col-lg-10">
            <div class="text-center">
                <h1 class="text-body">
                    <?= lang('app.name.break') ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="row gx-4 mt-3 justify-content-center text-body bg-body" data-bs-theme="light" id="width">
        <div class="col-lg-10">
            <div class="text-center">
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
                                    <input id="username" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <h6 class="text-body">Passwort: </h6>
                                    <input id="password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <img id="qr" class="w-25" src="" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="../../../assets/js/pdf.js" type="module"></script>
<script src="../../../assets/js/methods.js" type="module"></script>
<script type="module">
    import {UserCredentials} from "../../../assets/js/pdf";

    async function sendPdf(data) {
        const url = '<?=base_url('users/api/upload/pdf')?>'
        return await fetch(url, {
            method: "POST",
            mode: "cors",
            credentials: "same-origin",
            headers: {
                'Content-Type': "application/json"
            },
            body: JSON.stringify(data)
        })
    }


    function enableDownload() {
        document.getElementById('loading').hidden = true;
        document.getElementById('loaded').hidden = false;
        const downloadButton = document.getElementById('downloadButton');
        downloadButton.addEventListener('click', function () {
            openDownloadedFile();
        })
    }

    async function printAndPostCredentials() {
        const users = await fetchUsers();
        const smallUsers = users.filter(user => {
            return user.id < 110;
        })
        const pdfPromises = smallUsers.map(user => {
            const credentials = new UserCredentials(user, '<?=base_url()?>')
            return credentials.generateCredentialPdf()
        })
        console.log("PDF Promises generated", pdfPromises)
        const userData = await Promise.all(pdfPromises);
        console.log("User Data generated", userData);


    }


    async function fetchUsers() {
        return await fetch(
            '<?=base_url('users/api/all')?>',
            {
                method: "GET",
                credentials: 'same-origin',
            }
        ).then(response => response.json())
    }

    async function fetchQrCode(username, password) {
        return await fetch(
            '<?=base_url('users/api/generateQr')?>', {
                method: "POST",
                credentials: "same-origin",
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            }
        ).then(response => response.json())
    }


    document.addEventListener("DOMContentLoaded", async function () {
        await printAndPostCredentials()
        logTime();
        enableDownload();
    });


    function logTime(){
        const element = document.getElementById('time');
        element.innerText = ((Date.now() - startTime)/1000).toString();
    }

    function openDownloadedFile() {
        const url = '<?=base_url('users/credentials/download')?>';
        window.open(url, '_blank');
    }


</script>