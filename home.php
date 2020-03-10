<?php include './components/header.php'; 

    //$riepilogo = $argo->oggiScuola('2019-12-10'); 
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

                        if ($riepilogo[$x]['tipo'] == 'PRO') {

                            echo $riepilogo[$x]['dati']['desAnnotazioni'] . '<br>';
                            echo '<i>' . $riepilogo[$x]['dati']['desMittente'] . '</i>';

                        } else if ($riepilogo[$x]['tipo'] == 'COM') {

                            echo '<b>' . $riepilogo[$x]['dati']['desMateria'] . '</b> <br>';
                            echo $riepilogo[$x]['dati']['desCompiti'] . '<br>';
                            echo '<i>' . $riepilogo[$x]['dati']['docente'] . '</i>';

                        } else if ($riepilogo[$x]['tipo'] == 'ARG') {

                            echo '<b>' . $riepilogo[$x]['dati']['desMateria'] . '</b> <br>';
                            echo $riepilogo[$x]['dati']['desArgomento'] . '<br>';
                            echo '<i>' . $riepilogo[$x]['dati']['docente'] . '</i>';

                        } else if ($riepilogo[$x]['tipo'] == 'VOT') {


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

                    <?php } ?>

                </blockquote>
            </div>
        <?php }?>

    </div>
</main>


<?php include './components/footer.php'; ?>
