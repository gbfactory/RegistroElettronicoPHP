<?php include './components/header.php'; 

$compiti = $argo->compiti();

?>
<main>
    <div class="container">

        <h3 class="header">Compiti Assegnati</h3>

        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection">
                    <?php
                    for ($x = 0; $x < count($compiti); $x++) {
                        $datCompiti = $compiti[$x]['datCompiti'];
                        $datGiorno = $compiti[$x]['datGiorno'];
                        ?>
                        <li class="collection-item avatar">
                            <i class="material-icons circle <?= colore_data($datCompiti) ?>">book</i>
                            <span class="title"><?= $compiti[$x]['desMateria'] ?></span>
                            <p>Assegnati il <b><?= dataLeggibile($datGiorno) ?></b> per il <b><?= dataLeggibile($datCompiti) ?></b></p>
                            <p><?= linkCliccabili($compiti[$x]['desCompiti']) ?></p>
                            <p><i><?= rimuovi_parentesi($compiti[$x]['docente']) ?></i></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>

<?php include './components/footer.php'; ?>
