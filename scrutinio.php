<?php include './components/header.php';

$voti = $argo->votiGiornalieri();
$scrutinio = $argo->votiScrutinio();

?>
<main>

    <div class="container">

        <h3 class="header">Valutazioni</h3>

        <hr>

        <div class="row">

            <div class="col s12" style="margin-bottom: 1rem;">
                <ul class="tabs">
                    <li class="tab col s4"><a href="voti.php">RIEPILOGO</a></li>
                    <li class="tab col s4"><a href="valutazioni.php">VALUTAZIONI</a></li>
                    <li class="tab col s4"><a class="active" href="scrutinio.php">SCRUTINIO</a></li>
                </ul>
            </div>

            <?php

            function coloreVoto($voto) {
                if ($voto <= 1) {
                    return 'red darken-4';
                } else if (($voto >= 1) && ($voto < 5)) {
                    return 'red';
                } else if (($voto >= 5) && ($voto < 6)) {
                    return 'orange darken-4';
                } else if (($voto >= 6) && ($voto < 7)) {
                    return 'lime';
                } else if (($voto >= 7) && ($voto < 8)) {
                    return 'lime darken-2';
                } else if (($voto >= 8) && ($voto < 9)) {
                    return 'light-green';
                } else if (($voto >= 9) && ($voto < 10)) {
                    return 'green';
                } else if ($voto >= 10) {
                    return 'green darken-2';
                }
            }

            function coloreGrafico($voto) {
                if ($voto <= 1) {
                    return '183, 28, 28';
                } else if (($voto >= 1) && ($voto < 5)) {
                    return '244, 67, 54';
                } else if (($voto >= 5) && ($voto < 6)) {
                    return '230, 81, 0';
                } else if (($voto >= 6) && ($voto < 7)) {
                    return '205, 220, 57';
                } else if (($voto >= 7) && ($voto < 8)) {
                    return '175, 180, 43';
                } else if (($voto >= 8) && ($voto < 9)) {
                    return '139, 195, 74';
                } else if (($voto >= 9) && ($voto < 10)) {
                    return '76, 175, 80';
                } else if ($voto >= 10) {
                    return '56, 142, 60';
                }
            }

            function tipoProva($cod) {
                if ($cod == 'S') {
                    return 'Scritto';
                } else if ($cod == 'N') {
                    return 'Orale';
                } else if ($cod == 'P') {
                    return 'Pratico';
                }
            }

            ?>

            <?php
            $materie = [];

            $votiTotSomma = 0;
            $votiTriSomma = 0;
            $votiPenSomma = 0;

            $votiTotCount = count($voti);
            $votiTriCount = 0;
            $votiPenCount = 0;

            for ($x = 0; $x < count($voti); $x++) {

                $materia = $voti[$x]['desMateria'];
                $voto = $voti[$x]['decValore'];
                $data = strtotime($voti[$x]['datGiorno']);

                // Array materie
                if (!in_array($materia, $materie)) {
                    array_push($materie, $materia);
                }

                if ($voto != 0) {

                    // Media totale
                    $votiTotSomma += $voto;

                    // Media trimetre
                    $dataTri = strtotime('2019-12-31');
                    $dataPen = strtotime('2020-01-01');

                    if ($data <= $dataTri) {
                        $votiTriSomma += $voto;
                        $votiTriCount++;
                    } else if ($data >= $dataPen) {
                        $votiPenSomma += $voto;
                        $votiPenCount++;
                    }
                }
            }

            $mediaTot = round($votiTotSomma / $votiTotCount, 2);
            $mediaTri = round($votiTriSomma / $votiTriCount, 2);
            $mediaPen = round($votiPenSomma / $votiPenCount, 2);

            ?>

            <!--===================================
                SCRUTINIO
                ===================================-->
            <div id="scrutinio" class="col s12">
                <div class="row">
                    <div class="col s6">

                        <ul class="collection with-header">
                            <?php //print('<pre> ' . print_r($scrutinio, true) . '</pre>'); ?>

                            <?php
                            // Divisione periodi
                            $primoPeriodo = [];
                            $secondoPeriodo = [];

                            $default = $scrutinio[0]['prgPeriodo'];

                            for ($i=0; $i < count($scrutinio); $i++) { 

                                if ($scrutinio[$i]['prgPeriodo'] == $default) {
                                    array_push($primoPeriodo, $scrutinio[$i]);
                                } else {
                                    array_push($secondoPeriodo, $scrutinio[$i]);
                                }

                            }
                            ?>

                            <li class="collection-header"><h5>Primo Trimestre</h5></li>
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
                            <li class="collection-header"><h5>Scrutinio Finale</h5></li>
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

        </div>

    </div>
</main>

<?php include './components/footer.php'; ?>
