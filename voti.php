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

        $annoInizio = $schede[$scheda]['annoScolastico']['datInizio'];
        $annoFine = $schede[$scheda]['annoScolastico']['datFine'];

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

                            array_push(${"listaVoti" . $i}, $voti[$j]);

                            if ($voti[$j]['decValore'] != 0) {
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
                                <div class="col s12 m4">
                                    <h5><?= $materie[$i] ?></h5>
                                    <hr>
                                    Media complessiva: <b><?= $media ?></b>
                                    <div class="progress">
                                        <div class="determinate" style="width: <?= $media * 10 ?>%"></div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col 6">
                                            <svg class="sparkline<?= $i ?>1 sparkline--red" width="100" height="30" stroke-width="3"></svg>
                                            <svg class="sparkline<?= $i ?>1 sparkline--red sparkline--filled" width="100" height="30" stroke-width="3"></svg>
                                            <script>
                                                sparkline(document.querySelector(".sparkline<?= $i ?>1"), [1, 5, 2, 4, 8, 3, 7]);
                                            </script>
                                        </div>
                                        <div class="col 6">
                                            <?php $media1 = ${"numVoti1" . $i} > 0 ? ${"sommaVoti1" . $i} / ${"numVoti1" . $i} : 0; ?>
                                            Media Primo Periodo: <b><?= round($media1, 2) ?></b>
                                            <div class="progress">
                                                <div class="determinate" style="width: <?= $media1 * 10 ?>%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col 6">
                                            <svg class="sparkline<?= $i ?>2 sparkline--red" width="100" height="30" stroke-width="3"></svg>
                                            <svg class="sparkline<?= $i ?>2 sparkline--red sparkline--filled" width="100" height="30" stroke-width="3"></svg>
                                            <script>
                                                sparkline(document.querySelector(".sparkline<?= $i ?>2"), [1, 5, 2, 4, 8, 3, 7]);
                                            </script>
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
                                <div class="col s12 m8">
                                    <ul class="collection">
                                        <?php for ($j = 0; $j < count($listaVoti); $j++) { ?>
                                            <?php $voto = $listaVoti[$j]; ?>
                                            <li class="collection-item avatar">
                                                <i class="circle <?= coloreVoto($voto['decValore']) ?>"><?= $voto['codVoto'] ?></i>

                                                <span class="title">Prova <?= tipoProva($codProva = $voto['codVotoPratico'], true) ?> del <?= dataLeggibile($voto['datGiorno']) ?></span>

                                                <p><?php if ($voto['desProva'] != '') echo ('<b>Descrizione:</b> ' . $voto['desProva']); ?></p>
                                                <p><?php if ($voto['desCommento'] != '') echo ('<b>Commento:</b> ' . $voto['desCommento']); ?></p>
                                                <p><i><?= rimuovi_parentesi($voto['docente']); ?></i></p>
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

                            <p><?php if ($voti[$x]['desProva'] != '') echo ('<b>Descrizione:</b> ' . $voti[$x]['desProva']); ?></p>
                            <p><?php if ($voti[$x]['desCommento'] != '') echo ('<b>Commento:</b> ' . $voti[$x]['desCommento']); ?></p>
                            <p><i><?= rimuovi_parentesi($voti[$x]['docente']); ?></i></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.5/chartjs-plugin-annotation.js"></script>

<script>
    // Materialize Tabs
    $(document).ready(function() {
        $('.tabs').tabs();
    });

    // Grafico andamento voti
    var canvasContext = document.createElement("canvas").getContext("2d");

    var pinkBlue = canvasContext.createLinearGradient(140, 0, 150, 300.0);
    pinkBlue.addColorStop(0, "rgba(252,  70, 107, .9)");
    pinkBlue.addColorStop(1, "rgba(255, 255, 255, .0)");

    const graficoVoti = new Chart(document.getElementById('canvasAndamentoScolastico'), {
        type: "line",
        options: {
            tooltips: {
                mode: "index",
                intersect: false,
            },
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: false,
                }, ],
                yAxes: [{
                    display: true,
                }, ],
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
        },
        data: {
            labels: [
                <?php
                for ($x = 0; $x < count($voti); $x++) {
                    if ($voti[$x]['decValore'] != 0) {
                        echo ("'" . $voti[$x]['desMateria'] . "',");
                    }
                }
                ?>
            ],
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
                label: "Valutazione",
                fill: true,
                lineTension: 0.3,
                backgroundColor: pinkBlue,
                borderColor: "#d63384",
                borderCapStyle: "butt",
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: "miter",
                borderWidth: 1,
                pointBorderColor: "#d63384",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "#d63384",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                spanGaps: false
            }]
        }
    });
</script>

<?php include './components/footer.php'; ?>