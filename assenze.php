<?php include './components/header.php';

$argoAssenze = $argo->assenze();

?>
<main>

    <div class="container">
        <h3 class="header">Assenze Giornaliere</h3>

        <hr>

        <?php
        // Definizione arrays eventi
        $assenze = [];
        $ingressi = [];
        $uscite = [];

        // Classificazione voti in base agli eventi
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
                    <li class="tab col s3"><a href="#assenze">ASSENZE (<?= count($assenze) ?>)</a></li>
                    <li class="tab col s3"><a href="#ingressi">INGRESSI (<?= count($ingressi) ?>)</a></li>
                    <li class="tab col s3"><a href="#uscite">USCITE (<?= count($uscite) ?>)</a></li>
                </ul>
            </div>

            <div id="riepilogo" class="col s12">

                <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.css" rel="stylesheet">
                <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.css" rel="stylesheet">

                <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.js"></script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        
                        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                            plugins: ['dayGrid'],
                            locale: 'it',
                            events: [
                                <?php
                                for ($x = 0; $x < count($argoAssenze); $x++) {

                                    $codEvento = $argoAssenze[$x]['codEvento'];

                                    if ($codEvento == 'A') {
                                        echo ("{");
                                        echo ("title: 'Assenza',");
                                        echo ("start: '" . $argoAssenze[$x]['datAssenza'] . "'");
                                        echo ("},");
                                    } else if ($codEvento == 'I') {
                                        echo ("{");
                                        echo ("title: 'Ingresso " . $argoAssenze[$x]['numOra'] . "° ora',");
                                        echo ("start: '" . $argoAssenze[$x]['datAssenza'] . "'");
                                        echo ("},");
                                    } else if ($codEvento == 'U') {
                                        echo ("{");
                                        echo ("title: 'Uscita " . $argoAssenze[$x]['numOra'] . "° ora',");
                                        echo ("start: '" . $argoAssenze[$x]['datAssenza'] . "'");
                                        echo ("},");
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
                            <i class="circle material-icons red darken-4">close</i>

                            <span class="title">Assenza del <b><?= dataLeggibile($assenze[$x]['datAssenza']) ?></b></span>

                            <p>Registrata da <?= rimuovi_parentesi($assenze[$x]['registrataDa']) ?></p>

                            <?php if (isset($assenze[$x]['giustificataDa'])) { ?>
                                <p>Giustificata da <?= rimuovi_parentesi($assenze[$x]['giustificataDa']) ?> il <?= dataLeggibile($assenze[$x]['datGiustificazione']) ?>
                            <?php } else { ?>
                                <p>Da giustificare!</p>
                                <a class="secondary-content tooltipped" data-tooltip="Da giustificare!"><i class="material-icons">warning</i></a>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div id="ingressi" class="col s12">
                <ul class="collection">
                    <?php for ($x = 0; $x < count($ingressi); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle material-icons green darken-3">subdirectory_arrow_right</i>

                            <span class="title">Ingresso del <b><?= dataLeggibile($ingressi[$x]['datAssenza']) ?></b> in <b><?= $ingressi[$x]['numOra'] ?>° ora</b></span>

                            <p>Ingresso alle ore <?= substr($ingressi[$x]['oraAssenza'], -5) ?> registrato da <?= rimuovi_parentesi($ingressi[$x]['registrataDa']) ?></p>

                            <?php if (isset($ingressi[$x]['giustificataDa'])) { ?>
                                <p>Giustificato da <?= rimuovi_parentesi($ingressi[$x]['giustificataDa']) ?> il <?= dataLeggibile($ingressi[$x]['datGiustificazione']) ?></p>
                            <?php } else { ?>
                                <p>Da giustificare!</p>
                                <a class="secondary-content tooltipped" data-tooltip="Da giustificare!"><i class="material-icons">warning</i></a>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div id="uscite" class="col s12">
                <ul class="collection">
                    <?php for ($x = 0; $x < count($uscite); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="circle material-icons orange darken-4">subdirectory_arrow_left</i>
                            
                            <span class="title">Uscita del <b><?= dataLeggibile($uscite[$x]['datAssenza']) ?></b> in <b><?= $uscite[$x]['numOra'] ?>° ora</b></span>

                            <p>Uscita alle ore <?= substr($uscite[$x]['oraAssenza'], -5) ?> registrata da <?= rimuovi_parentesi($uscite[$x]['registrataDa']) ?></p>

                            <?php if (isset($uscite[$x]['giustificataDa'])) { ?>
                                <p>Giustificato da <?= rimuovi_parentesi($uscite[$x]['giustificataDa']) ?> il <?= dataLeggibile($uscite[$x]['datGiustificazione']) ?></p>
                            <?php } else { ?>
                                <p>Da giustificare!</p>
                                <a class="secondary-content tooltipped" data-tooltip="Da giustificare!"><i class="material-icons">warning</i></a>
                            <?php } ?>
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
