<?php include './components/header.php'; 

$argoAssenze = $argo->assenze();

?>
<main>

    <div class="container">
        <h3 class="header">Assenze, Ingressi e Uscite</h3>

        <hr>

        <?php 

            //print( '<pre> ' . print_r($argoAssenze, true) . '</pre>');

            // Definizione arrays
            $assenze = [];
            $ingressi = [];
            $uscite = [];

            // Classificazione voti
            for ($x = 0; $x < count($argoAssenze); $x++) {

                $codEvento = $argoAssenze[$x]['codEvento'];

                if ($codEvento == 'A') {
                    array_push($assenze, $argoAssenze[$x]);
                } else if ($codEvento == 'I') {
                    array_push($ingressi, $argoAssenze[$x]);
                } else if ($codEvento == 'U') {
                    array_push($uscite, $argoAssenze[$x]);
                }

            };

        ?>

        <div class="row">

            <div class="col s12" style="margin-bottom: 1rem;">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#riepilogo">RIEPILOGO</a></li>
                    <li class="tab col s3"><a href="#assenze">ASSENZE</a></li>
                    <li class="tab col s3"><a href="#ingressi">INGRESSI</a></li>
                    <li class="tab col s3"><a href="#uscite">USCITE</a></li>
                </ul>
            </div>

            <div id="riepilogo" class="col s12">

                <link href="./assets/fullcalendar/core/main.css" rel="stylesheet">
                <link href="./assets/fullcalendar/daygrid/main.css" rel="stylesheet">

                <script src="./assets/fullcalendar/core/main.js"></script>
                <script src="./assets/fullcalendar/daygrid/main.js"></script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var calendarEl = document.getElementById('calendar');

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            plugins: [ 'dayGrid' ],

                            events: [
                                <?php   
                                    for ($x = 0; $x < count($argoAssenze); $x++) {

                                        $codEvento = $argoAssenze[$x]['codEvento'];
                        
                                        if ($codEvento == 'A') {

                                            echo("{");
                                                echo("title: 'Assenza',");
                                                echo("start: '" . $argoAssenze[$x]['datAssenza'] . "'");
                                            echo("},");

                                        } else if ($codEvento == 'I') {

                                            echo("{");
                                                echo("title: 'Ingresso " . $argoAssenze[$x]['numOra'] . "° ora',");
                                                echo("start: '" . $argoAssenze[$x]['datAssenza'] . "'");
                                            echo("},");

                                        } else if ($codEvento == 'U') {

                                            echo("{");
                                                echo("title: 'Uscita " . $argoAssenze[$x]['numOra'] . "° ora',");
                                                echo("start: '" . $argoAssenze[$x]['datAssenza'] . "'");
                                            echo("},");

                                        }
                                    };
                                ?>
                            ]

                        });

                        calendar.render();

                    });
                </script>

                <div id="calendar"></div>

            </div>

            <div id="assenze" class="col s12">
                <ul class="collection">
                <?php for ($x = 0; $x < count($assenze); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle material-icons">close</i>
                            <span class="title">Assenza del <b><?= $assenze[$x]['datAssenza'] ?></b></span>
                            <p>Registrata da <?= $assenze[$x]['registrataDa'] ?></p>
                            <?php
                                if ($assenze[$x]['giustificataDa']) {
                                    echo('<p>Giustificata da ' . $assenze[$x]['giustificataDa'] . ' il ' . $assenze[$x]['datGiustificazione']);
                                } else {
                                    echo('<a class="secondary-content tooltipped" data-tooltip="Da giustificare!"><i class="material-icons">warning</i></a>'); 
                                }
                            ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div id="ingressi" class="col s12">
                <ul class="collection">
                <?php for ($x = 0; $x < count($ingressi); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle material-icons">subdirectory_arrow_right</i>
                            <span class="title">Ingresso in <?= $ingressi[$x]['numOra'] ?> ora il <b><?= $ingressi[$x]['datAssenza'] ?></b></span>
                            <p>Ingresso alle ore <?= substr($ingressi[$x]['oraAssenza'], -5) ?> segnato da <?= $ingressi[$x]['registrataDa'] ?></p>
                            <?php
                                /*if ($ingressi[$x]['giustificataDa']) {
                                    echo('<p>Giustificato da ' . $ingressi[$x]['giustificataDa'] . ' il ' . $ingressi[$x]['datGiustificazione']);
                                } else {
                                    echo('<a class="secondary-content tooltipped" data-tooltip="Da giustificare!"><i class="material-icons">warning</i></a>'); 
                                }*/
                            ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div id="uscite" class="col s12">
                <ul class="collection">
                <?php for ($x = 0; $x < count($uscite); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle material-icons">subdirectory_arrow_left</i>
                            <span class="title">Uscita in <?= $uscite[$x]['numOra'] ?> ora il <b><?= $uscite[$x]['datAssenza'] ?></b></span>
                            <p>Uscita alle ore <?= substr($uscite[$x]['oraAssenza'], -5) ?> segnata da <?= $uscite[$x]['registrataDa'] ?></p>
                            <?php
                                /*if ($uscite[$x]['giustificataDa']) {
                                    echo('<p>Giustificata da ' . $uscite[$x]['giustificataDa'] . ' il ' . $uscite[$x]['datGiustificazione']);
                                } else {
                                    echo('<a class="secondary-content tooltipped" data-tooltip="Da giustificare!"><i class="material-icons">warning</i></a>'); 
                                }*/
                            ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>


        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
