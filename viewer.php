<?php
$viewer = TRUE;
$cod = "bac";
$titolo = $_GET["desFile"];

include './components/header.php';

?>

<main>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="section">
                    <div class="card">
                        <p>Reindirizzamento in corso...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $.ajax({
        type: "POST",
        url: "https://www.portaleargo.it/famiglia/api/rest/messaggiobachecanuova",
        headers: {
            "x-version": "2.4.3",
            "x-key-app": "ax6542sdru3217t4eesd9",
            "x-app-code": "APF",
            "x-prg-scheda": 1,
            "x-prg-alunno": <?= intval($codAlunno); ?>,
            "x-auth-token": "<?= $token; ?>",
            "x-produttore-software": "ARGO Software s.r.l. - Ragusa",
            "x-cod-min": "<?= $codice; ?>",
            "x-prg-scuola": 1,
        },
        data: JSON.stringify({
            "prgAllegato": <?= $_GET['prgAllegato'] ?>,
            "prgMessaggio": <?= $_GET['prgMessaggio'] ?>
        }),
        contentType: 'application/json',
        success: function(data) {
            if (data['success'] == true) {
                console.log(data['url']);
                window.location = data['url'];
            }
        },
        error: function(errMsg) {

        }
    });
</script>

<?php include './components/footer.php'; ?>