<?php
$cod = "vot";
$titolo = "Voti Giornalieri";

include './components/header.php';

$voti = $argo->votiGiornalieri();
$schede = $argo->schede();
?>

<main>
    <div class="container">

        <?php
        $materie = [];

        $votiTotSomma = 0;
        $votiTriSomma = 0;
        $votiPenSomma = 0;

        $votiTotCount = count($voti);
        $votiTriCount = 0;
        $votiPenCount = 0;

        $annoInizio = $schede[0]['annoScolastico']['datInizio'];
        $annoFine = $schede[0]['annoScolastico']['datFine'];

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
                // $dataTri = strtotime(explode('-', $annoFine)[0] . '-01-31');
                // $dataPen = strtotime(explode('-', $annoFine)[0] . '-06-31');

                $dataTri = (strtotime('2021-01-31'));
                $dataPen = (strtotime('2021-06-31'));

                if ($data <= $dataTri) {
                    $votiTriSomma += $voto;
                    $votiTriCount++;
                } else /*if ($data >= $dataPen)*/ {
                    $votiPenSomma += $voto;
                    $votiPenCount++;
                }
            }
        }

        $mediaTot = $votiTotCount > 0 ? round($votiTotSomma / $votiTotCount, 2) : 0;
        $mediaTri = $votiTriCount > 0 ? round($votiTriSomma / $votiTriCount, 2) : 0;
        $mediaPen = $votiPenCount > 0 ? round($votiPenSomma / $votiPenCount, 2) : 0;
        ?>

        <div class="row">

            <div class="col s12" style="margin-bottom: 1rem;">
                <ul class="tabs">
                    <li class="tab col s4"><a class="active" href="#riepilogo">RIEPILOGO</a></li>
                    <li class="tab col s4"><a href="#materie">MATERIE</a></li>
                    <li class="tab col s4"><a href="#valutazioni">VALUTAZIONI</a></li>
                </ul>
            </div>

            <div id="riepilogo" class="col s12">

                <div class="row">
                    <div class="col s12 m4 l4">
                        <div class="card">
                            <div class="card-content">
                                <h5 class="text-pink">Media Complessiva</h5>
                                <h3><?= $mediaTot ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 m4 l4">
                        <div class="card">
                            <div class="card-content">
                                <h5 class="text-pink">Media Primo Periodo</h5>
                                <h3><?= $mediaTri ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 m4 l4">
                        <div class="card">
                            <div class="card-content">
                                <h5 class="text-pink">Media Secondo Periodo</h5>
                                <h3><?= $mediaPen ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="text-pink" style="margin-top: 0">Andamento Valutazioni</h4>
                                <canvas id="canvasAndamentoScolastico"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.5/chartjs-plugin-annotation.js"></script>

                <script>
                    // Grafico andamennto scolastico
                    var canvasAndamento = document.getElementById('canvasAndamentoScolastico').getContext('2d');

                    var dataAndamento = {
                        datasets: [{
                            data: [
                                <?php
                                for ($x = 0; $x < count($voti); $x++) {
                                    if ($voti[$x]['decValore'] != 0) {
                                        echo ($voti[$x]['decValore'] . ',');
                                    }
                                }
                                ?>
                            ],
                            fill: false,
                            backgroundColor: 'rgb(255, 159, 64)',
                            borderColor: 'rgb(255, 205, 86)'
                        }],
                        labels: [
                            <?php
                            for ($x = 0; $x < count($voti); $x++) {
                                if ($voti[$x]['decValore'] != 0) {
                                    echo ("'" . $voti[$x]['desMateria'] . "',");
                                }
                            }
                            ?>
                        ]
                    };

                    var grafAndamento = new Chart(canvasAndamento, {
                        type: 'line',
                        data: dataAndamento,
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    display: false
                                }],
                                yAxes: [{
                                    display: true
                                }],
                            },
                            elements: {
                                line: {
                                    tension: 0
                                }
                            },
                            annotation: {
                                annotations: [{
                                    drawTime: "afterDatasetsDraw",
                                    type: "line",
                                    mode: "horizontal",
                                    scaleID: "y-axis-0",
                                    value: 6,
                                    borderColor: "rgb(212, 55, 73)",
                                    borderWidth: 2,
                                }]
                            }
                        }
                    });


                    // Grafici medie periodi
                    var canvasMediaComp = document.getElementById('canvasMediaComplessiva').getContext('2d');
                    var canvasMediaTrim = document.getElementById('canvasMediaTrimestre').getContext('2d');
                    var canvasMediaPent = document.getElementById('canvasMediaPentamestre').getContext('2d');

                    var dataMediaComp = {
                        datasets: [{
                            data: [
                                <?= $mediaTot . ',' . (10 - $mediaTot) ?>
                            ],
                            backgroundColor: [
                                'rgb(<?= coloreGrafico($mediaTot) ?>)',
                                'rgb(161, 161, 161)',
                            ]
                        }],
                        labels: [
                            'Media complessiva',
                            'Restante'
                        ]
                    };

                    var dataMediaTrim = {
                        datasets: [{
                            data: [
                                <?= $mediaTri . ',' . (10 - $mediaTri) ?>
                            ],
                            backgroundColor: [
                                'rgb(<?= coloreGrafico($mediaTri) ?>)',
                                'rgb(161, 161, 161)',
                            ]
                        }],
                        labels: [
                            'Media Trimetre',
                            'Restante'
                        ]
                    };

                    var dataMediaPent = {
                        datasets: [{
                            data: [
                                <?= $mediaPen . ',' . (10 - $mediaPen) ?>
                            ],
                            backgroundColor: [
                                'rgb(<?= coloreGrafico($mediaPen) ?>)',
                                'rgb(161, 161, 161)',
                            ]
                        }],
                        labels: [
                            'Media Pentamentre',
                            'Restante'
                        ]
                    };

                    var grafMediaComp = new Chart(canvasMediaComp, {
                        type: 'doughnut',
                        data: dataMediaComp,
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            }
                        }
                    });

                    var grafMediaTrim = new Chart(canvasMediaTrim, {
                        type: 'doughnut',
                        data: dataMediaTrim,
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            }
                        }
                    });

                    var grafMediaPent = new Chart(canvasMediaPent, {
                        type: 'doughnut',
                        data: dataMediaPent,
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            }
                        }
                    });
                </script>

            </div>

            <div id="materie" class="col s12">

                <?php
                for ($i = 0; $i < count($materie); $i++) {
                    ${"sommaVoti1" . $i} = 0;
                    ${"numVoti1" . $i} = 0;
                    ${"listaVoti1" . $i} = [];

                    ${"sommaVoti2" . $i} = 0;
                    ${"numVoti2" . $i} = 0;
                    ${"listaVoti2" . $i} = [];

                    ${"listaVoti" . $i} = [];

                    for ($j = 0; $j < count($voti); $j++) {

                        if ($voti[$j]['desMateria'] == $materie[$i]) {

                            if ($voti[$j]['decValore'] != 0) {
                                array_push(${"listaVoti" . $i}, $voti[$j]);

                                if (strtotime($voti[$j]['datGiorno']) <= $dataTri) {
                                    ${"sommaVoti1" . $i} += $voti[$j]['decValore'];
                                    ${"numVoti1" . $i}++;
                                    array_push(${"listaVoti1" . $i}, $voti[$j]);
                                } else /*if (strtotime($voti[$j]['datGiorno']) >= $dataPen)*/ {
                                    ${"sommaVoti2" . $i} += $voti[$j]['decValore'];
                                    ${"numVoti2" . $i}++;
                                    array_push(${"listaVoti2" . $i}, $voti[$j]);
                                }
                            }
                        }
                    }
                }
                ?>

                <?php
                for ($i = 0; $i < count($materie); $i++) {

                    $sommaVoti = ${"sommaVoti1" . $i} + ${"sommaVoti2" . $i};
                    $numVoti = ${"numVoti1" . $i} + ${"numVoti2" . $i};
                    $listaVoti = ${"listaVoti" . $i};
                    $media = round($sommaVoti / $numVoti, 2);
                ?>

                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 m5">
                                    <h5><?= $materie[$i] ?></h5>
                                    <hr>
                                    Media complessiva: <b><?= $media ?></b>
                                    <div class="progress">
                                        <div class="determinate" style="width: <?= $media * 10 ?>%"></div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col 6">
                                            <?php $media1 = ${"numVoti1" . $i} > 0 ? ${"sommaVoti1" . $i} / ${"numVoti1" . $i} : 0; ?>
                                            Media Primo Periodo: <b><?= round($media1, 2) ?></b>
                                            <div class="progress">
                                                <div class="determinate" style="width: <?= $media1 * 10 ?>%"></div>
                                            </div>
                                        </div>
                                        <div class="col 6">
                                            <?php $media2 = ${"numVoti2" . $i} > 0 ? ${"sommaVoti2" . $i} / ${"numVoti2" . $i} : 0; ?>
                                            Media Secondo Periodo: <b><?= round($media2, 2) ?></b>
                                            <div class="progress">
                                                <div class="determinate" style="width: <?= $media2 * 10 ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col s12 m7">
                                    <ul class="collection">
                                        <?php for ($j = 0; $j < count($listaVoti); $j++) { ?>
                                            <?php $voto = $listaVoti[$j]; ?>
                                            <li class="collection-item avatar">
                                                <i class="circle <?= coloreVoto($voto['decValore']) ?>"><?= $voto['codVoto'] ?></i>

                                                <span class="title">Prova <?= tipoProva($codProva = $voto['codVotoPratico'], true) ?> del <?= dataLeggibile($voto['datGiorno']) ?></span>

                                                <p><?php if ($voto['desProva'] != '') echo ('<b>Descrizione:</b> ' . $voto['desProva']); ?>
                                                    <p><?php if ($voto['desCommento'] != '') echo ('<b>Commento:</b> ' . $voto['desCommento']); ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div id="valutazioni" class="col s12">
                <ul class="collection">
                    <?php for ($x = 0; $x < count($voti); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle <?= coloreVoto($voti[$x]['decValore']) ?>"><?= $voti[$x]['codVoto'] ?></i>

                            <span class="title"><?= $voti[$x]['desMateria'] ?>
                                <?php if (substr($voti[$x]['desCommento'], -14) == '(non fa media)') echo '<b>(Non fa media)</b>'; ?>
                            </span>

                            <p><?= dataLeggibile($voti[$x]['datGiorno']) ?> - <?= tipoProva($codProva = $voti[$x]['codVotoPratico']) ?></p>

                            <p><?php if ($voti[$x]['desProva'] != '') echo ('<b>Descrizione:</b> ' . $voti[$x]['desProva']); ?>
                                <p><?php if ($voti[$x]['desCommento'] != '') echo ('<b>Commento:</b> ' . $voti[$x]['desCommento']); ?>
                                    <p><i><?= rimuovi_parentesi($voti[$x]['docente']); ?></i></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('.tabs').tabs();
    });
</script>

<?php include './components/footer.php'; ?>