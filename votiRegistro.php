<?php include './components/header.php';

$voti = $argo->votiGiornalieri();
$scrutinio = $argo->votiScrutinio();

?>
<main>

    <div class="container">
        <h3 class="header">Valutazioni</h3>

        <hr>

        <?php //print('<pre> ' . print_r($voti, true) . '</pre>'); ?>

        <div class="row">

            <div class="col s12" style="margin-bottom: 1rem;">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#riepilogo" onclick="$('.header').html('Riepilogo Valutazioni')">RIEPILOGO</a></li>
                    <li class="tab col s3"><a href="#valutazioni" onclick="$('.header').html('Voti Giornalieri')">VALUTAZIONI</a></li>
                    <li class="tab col s3"><a href="#scrutinio" onclick="$('.header').html('Voti Scrutinio')">SCRUTINIO</a></li>
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

                /*print('<pre> ' . print_r($materie, true) . '</pre>');
                echo($mediaTot . '<br>' . $mediaTri . '<br>' . $mediaPen);*/

            ?>

            <!--===================================
                RIEPILOGO VOTI
                ===================================-->
            <div id="riepilogo" class="col s12">

                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card-panel hoverable">
                            <b>Andamento Scolastico</b>
                            <canvas id="canvasAndamentoScolastico"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m4 l4">
                        <div class="card-panel hoverable">
                            <b>Media Complessiva</b>
                            <canvas id="canvasMediaComplessiva"></canvas>
                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card-panel hoverable">
                            <b>Media Trimestre</b>
                            <canvas id="canvasMediaTrimestre"></canvas>
                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card-panel hoverable">
                            <b>Media Pentamestre</b>
                            <canvas id="canvasMediaPentamestre"></canvas>
                        </div>
                    </div>
                </div>

                <!--<div class="row">
                    <div class="col s6 m4 l3">
                        <div class="card-panel hoverable">
                            <b>Media Pentamestre</b>
                        </div>
                    </div>
                    <div class="col s6 m4 l3">
                        <div class="card-panel hoverable">
                            <b>Media Pentamestre</b>
                        </div>
                    </div>
                    <div class="col s6 m4 l3">
                        <div class="card-panel hoverable">
                            <b>Media Pentamestre</b>
                        </div>
                    </div>
                    <div class="col s6 m4 l3">
                        <div class="card-panel hoverable">
                            <b>Media Pentamestre</b>
                        </div>
                    </div>
                </div>-->

                <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.5/chartjs-plugin-annotation.js"></script>

                <script>
                    // Grafico andamennto scolastico
                    var canvasAndamento = document.getElementById('canvasAndamentoScolastico').getContext('2d');

                    var dataAndamento = {
                        datasets: [
                            {
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
                            }
                        ],
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
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
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
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
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
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
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
            <!--===================================
                VALUTAZIONI
                ===================================-->
            <div id="valutazioni" class="col s12">
                <ul class="collection">
                    <?php for ($x = 0; $x < count($voti); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle <?= coloreVoto($voti[$x]['decValore']) ?>"><?= $voti[$x]['codVoto'] ?></i>
                            <span class="title"><?= $voti[$x]['desMateria'] ?></span>
                            <p><?= $voti[$x]['datGiorno'] ?> - <?= tipoProva($codProva = $voti[$x]['codVotoPratico']) ?></p>
                            <p>
                                <?php
                                if ($voti[$x]['desProva'] != '') {
                                    echo ('Descrizione: ' . $voti[$x]['desProva']) . '<br>';
                                }
                                if ($voti[$x]['desCommento'] != '') {
                                    echo ('Commento: ' . $voti[$x]['desCommento']) . '<br>';
                                }
                                echo ($voti[$x]['docente']);
                                ?>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!--===================================
                SCRUTINIO
                ===================================-->
            <div id="scrutinio" class="col s12">
                <ul class="collection">
                    <?php for ($x = 0; $x < count($scrutinio); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle <?= coloreVoto($scrutinio[$x]['votoOrale']['codVoto']) ?>"><?= $scrutinio[$x]['votoOrale']['codVoto'] ?></i>
                            <span class="title"><?= $scrutinio[$x]['desMateria'] ?> </b></span>
                            <p><?= 'Giudizio sintetico: ' . $scrutinio[$x]['giudizioSintetico'] ?></p>

                        </li>
                    <?php } ?>
                </ul>
            </div>

        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
