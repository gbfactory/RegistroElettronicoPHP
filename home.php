<?php include './components/header.php'; 

    //$riepilogo = $argo->oggiScuola('2020-01-31'); 
    $riepilogo = $argo->oggiScuola(date('Y-m-d')); 
    
?>

<main>
    <div class="container">

        <?php //print( '<pre> ' . print_r($riepilogo, true) . '</pre>') ?>

        <h3 class="header">Riepilogo giornaliero</h3>

        <h6><?php echo date("l") . " " . date("d") . " " .  date("F", strtotime(date("Y-m-d"))) . " " . date("Y"); ?></h6>

        <hr>

        <?php for ($x = 0; $x < count($riepilogo); $x++) { ?>
            <div>
                <p class="riepilogo-titolo grey lighten-2"><b><?php echo $riepilogo[$x]['titolo'] ?></b></p>
                <blockquote>
                    <?php 

                        $tipo = $riepilogo[$x]['tipo'];

                        // Promemoria
                        if ($tipo == 'PRO') {

                            echo $riepilogo[$x]['dati']['desAnnotazioni'] . '<br>';
                            echo '<i>' . $riepilogo[$x]['dati']['desMittente'] . '</i>';

                        // Compiti assegnati
                        } else if ($tipo == 'COM') {

                            echo '<b>' . $riepilogo[$x]['dati']['desMateria'] . '</b> <br>';
                            echo $riepilogo[$x]['dati']['desCompiti'] . '<br>';
                            echo '<i>' . $riepilogo[$x]['dati']['docente'] . '</i>';

                        // Argomenti lezione
                        } else if ($tipo == 'ARG') {

                            echo '<b>' . $riepilogo[$x]['dati']['desMateria'] . '</b> <br>';
                            echo $riepilogo[$x]['dati']['desArgomento'] . '<br>';
                            echo '<i>' . $riepilogo[$x]['dati']['docente'] . '</i>';

                        // Voto
                        } else if ($tipo == 'VOT') {


                            $codProva = $riepilogo[$x]['dati']['codVotoPratico'];
                            if ($codProva == 'S') {
                                $tipProva = 'Scritto';
                            } else if ($codProva == 'N') {
                                $tipProva == 'Orale';
                            } else if ($codProva == 'P') {
                                $tipProva == 'Pratico';
                            }
    
                            $voto = $riepilogo[$x]['dati']['decValore'];
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
                            
                            <div class="row valign-wrapper">
                                <div class="col s1">
                                    <?php echo '<i class="circle '. $vColor . '">' . $riepilogo[$x]['dati']['codVoto'] . '</i>';  ?>
                                </div>
                                <div class="col s12">
                                    <span class="black-text">
                                        <?php
                                            echo '<b>' . $riepilogo[$x]['dati']['desMateria'] . '</b> <br>';

                                            if ($voti[$x]['desProva'] != '') {
                                                echo $riepilogo[$x]['dati']['desProva'] . '<br>';
                                            }
                
                                            if ($voti[$x]['desCommento'] != '') {
                                                echo $riepilogo[$x]['dati']['desCommento'] . '<br>';
                                            }
                
                                            echo '<i>' . $riepilogo[$x]['dati']['docente'] . '</i>';
                                        ?>
                                    </span>
                                </div>
                            </div>
                        <?php 
                        
                        // Bacheca    
                        } else if ($tipo == 'BAC') {
                            echo '<b>' . $riepilogo[$x]['dati']['desOggetto'] . '</b> <br>';
                            echo $riepilogo[$x]['dati']['desMessaggio'];
                            
                        // Note
                        } else if ($tipo == 'NOT') {
                            echo $riepilogo[$x]['dati']['desNota'] . '<br>';
                            echo '<i>' . $riepilogo[$x]['dati']['docente'] . '</i>';
                        }  ?>

                </blockquote>
            </div>
        <?php }?>

    </div>
</main>


<?php include './components/footer.php'; ?>
