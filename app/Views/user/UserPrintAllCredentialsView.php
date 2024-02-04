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


<main id="print" style="opacity: 0;">
    <div class="row gx-4 justify-content-center">
        <div class="col-lg-10 mt-5">
            <div class="text-center">
                <h1 class="text-body">
                    <?= lang('app.name.break') ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="row gx-4 mt-3 justify-content-center text-body bg-body" id="width">
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
                            <img id="qr" src="" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    let startTime = "";

    async function generatePdf(user) {
        window.jsPDF = window.jspdf.jsPDF;
        const canvas = await generateCanvas(user);
        const base64Pdf = await generatePdfFromCanvas(canvas);
        return {
            data: base64Pdf,
            userId: user.id
        }
    }

    async function generateCanvas(user) {
        const element = document.getElementById('print');
        return await html2canvas(element, {
            onclone: function (clone) {
                const element = clone.getElementById('print');
                const nameElement = clone.getElementById('username');
                const passwordElement = clone.getElementById('password');
                const qrCodeElement = clone.getElementById('qr');
                nameElement.value = user.name;
                passwordElement.value = user.password;
                qrCodeElement.src = user.qrCodeUrl;
                element.style.opacity = "1";
            },
            allowTaint: true,
            useCORS: true,
            scale: 5,
            windowWidth: 1000,
            windowHeight: 1200
        })
    }

    async function generatePdfFromCanvas(canvas) {
        const data = canvas.toDataURL('image/jpeg');
        const aspectRatio = canvas.height / canvas.width;
        const pdfDocument = new jsPDF({
            orientation: "portrait",
            unit: "pt",
            format: "a4"
        })
        const width = pdfDocument.internal.pageSize.width;
        const height = width * aspectRatio;
        pdfDocument.addImage(data, 'jpeg', 0, 0, width, height);
        return btoa(pdfDocument.output());
    }

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
        startTime = Date.now();
        const users = await fetchUsers();
        await Promise.all(users.map(async user => {
            const pdf = await generatePdf(user)
            sendPdf(pdf).catch(err => console.log(err))
        }))
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

    async function printCredentials(user) {
        return await generatePdf(user)
    }

    document.addEventListener("DOMContentLoaded", async function () {
        document.querySelector("html").setAttribute("data-bs-theme", "light");

        await printAndPostCredentials()
        logTime();
        enableDownload();
    });

    function logTime() {
        const element = document.getElementById('time');
        element.innerText = ((Date.now() - startTime) / 1000).toString();
    }

    function openDownloadedFile() {
        const url = '<?=base_url('users/credentials/download')?>';
        window.open(url, '_blank');
    }

    function setError() {

    }
</script>