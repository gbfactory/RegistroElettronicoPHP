<?php include './components/header.php'; 

$voti = $argo->votiGiornalieri();

?>
<main>

    <div class="container">
        <h3 class="header">Valutazioni</h3>

        <hr>

        <?php 
            /*for ($x = 0; $x < count($voti); $x++) {
                print_r($voti[$x]);
                echo('<br><br>');
            };*/
        ?>

        <div class="row">

            <div class="col s12" style="margin-bottom: 1rem;">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#riepilogo">RIEPILOGO</a></li>
                    <li class="tab col s3"><a href="#valutazioni">VALUTAZIONI</a></li>
                    <li class="tab col s3"><a href="#scrutinio">SCRUTINIO</a></li>
                </ul>
            </div>

            <!--===================================
                RIEPILOGO VOTI
                ===================================-->
            <div id="riepilogo" class="col s12">
                Welcome!
            </div>
            <!--===================================
                VALUTAZIONI
                ===================================-->
            <div id="valutazioni" class="col s12">
                <ul class="collection">
                <?php for ($x = 0; $x < count($voti); $x++) { 

                        // Tipologia di prova
                        $codProva = $voti[$x]['codVotoPratico'];
                        if ($codProva == 'S') {
                            $tipProva = 'Scritto';
                        } else if ($codProva == 'N') {
                            $tipProva = 'Orale';
                        } else if ($codProva == 'P') {
                            $tipProva = 'Pratico';
                        }

                        // Colore del voto
                        $voto = $voti[$x]['decValore'];
                        if ($voto <= 1) {
                            $vColor = 'red darken-4';
                        } else if (($voto >= 1) && ($voto < 5)) {
                            $vColor = 'red';
                        } else if (($voto >= 5) && ($voto < 6)) {
                            $vColor = 'orange darken-4';
                        } else if (($voto >= 6) && ($voto < 7)) {
                            $vColor = 'lime';
                        } else if (($voto >= 7) && ($voto < 8)) {
                            $vColor = 'lime darken-2';
                        } else if (($voto >= 8) && ($voto < 9)) {
                            $vColor = 'light-green';
                        } else if (($voto >= 9) && ($voto < 10)) {
                            $vColor = 'green';
                        } else if ($voto >= 10) {
                            $vColor = 'green darken-2';
                        }

                    ?>
                        <li class="collection-item avatar">
                            <i class="circle <?= $vColor ?>"><?= $voti[$x]['codVoto'] ?></i>
                            <span class="title"><?= $voti[$x]['desMateria'] ?></span>
                            <p><?= $voti[$x]['datGiorno'] ?> - <?= $tipProva ?></p>
                            <p>
                            <?php
                                if ($voti[$x]['desProva'] != '') {
                                    echo('Descrizione: ' . $voti[$x]['desProva']) . '<br>';
                                }
                                if ($voti[$x]['desCommento'] != '') {
                                    echo('Commento: ' . $voti[$x]['desCommento']) . '<br>';
                                }
                                echo($voti[$x]['docente']);
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
                Scrutinio page
            </div>

        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
