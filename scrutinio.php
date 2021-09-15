<?php
$cod = "vsc";
$titolo = "Voti Scrutinio";

include './components/header.php';

$periodi = $argo->periodi();
$scrutinio = $argo->votiScrutinio();
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col s6">
                <ul class="collection with-header">
                    <?php //print('<pre> ' . print_r($scrutinio, true) . '</pre>'); 
                    ?>

                    <?php
                    // Divisione periodi
                    $primoPeriodo = [];
                    $secondoPeriodo = [];

                    $default = $scrutinio[0]['prgPeriodo'];

                    for ($i = 0; $i < count($scrutinio); $i++) {

                        if ($scrutinio[$i]['prgPeriodo'] == $default) {
                            array_push($primoPeriodo, $scrutinio[$i]);
                        } else {
                            array_push($secondoPeriodo, $scrutinio[$i]);
                        }
                    }
                    ?>

                    <li class="collection-header">
                        <h5>Primo Trimestre</h5>
                    </li>
                    <?php for ($x = 0; $x < count($primoPeriodo); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle <?= coloreVoto($primoPeriodo[$x]['votoOrale']['codVoto']) ?>"><?= $primoPeriodo[$x]['votoOrale']['codVoto'] ?></i>
                            <span class="title"><?= $primoPeriodo[$x]['desMateria'] ?> </b></span>
                            <?php if ($primoPeriodo[$x]['assenze'] != "") { ?>
                                <p><b>Assenze: </b> <?= $primoPeriodo[$x]['assenze'] ?></p>
                            <?php } ?>
                            <?php if ($primoPeriodo[$x]['giudizioSintetico'] != "") { ?>
                                <p><b>Giudizio: </b><?= $primoPeriodo[$x]['giudizioSintetico'] ?></p>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="col s6">
                <ul class="collection with-header">
                    <li class="collection-header">
                        <h5>Scrutinio Finale</h5>
                    </li>
                    <?php for ($x = 0; $x < count($secondoPeriodo); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle <?= coloreVoto($secondoPeriodo[$x]['votoOrale']['codVoto']) ?>"><?= $secondoPeriodo[$x]['votoOrale']['codVoto'] ?></i>
                            <span class="title"><?= $secondoPeriodo[$x]['desMateria'] ?> </b></span>
                            <?php if ($secondoPeriodo[$x]['assenze'] != "") { ?>
                                <p><b>Assenze: </b> <?= $secondoPeriodo[$x]['assenze'] ?></p>
                            <?php } ?>
                            <?php if ($secondoPeriodo[$x]['giudizioSintetico'] != "") { ?>
                                <p><b>Giudizio: </b><?= $secondoPeriodo[$x]['giudizioSintetico'] ?></p>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div>
</main>

<?php include './components/footer.php'; ?>