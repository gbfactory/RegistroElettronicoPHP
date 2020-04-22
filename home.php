<?php include './components/header.php';

//$riepilogo = $argo->oggiScuola('2020-01-31'); 

if (isset($_GET['date'])) {
    $date = $_GET['date'];


    $datejs = explode('-', $date);
    $datejsanno = $datejs[0];
    $datejsmese = $datejs[1] - 1;
    $datejsgiorno = $datejs[2];

} else {
    $date = date('Y-m-d');

    $datejsanno = date('Y');
    $datejsmese = date('m') - 1;
    $datejsgiorno = date('d');
}

$riepilogo = $argo->oggiScuola($date);

?>

<main>
    <div class="container">

        <?php //print( '<pre> ' . print_r($riepilogo, true) . '</pre>') 
        ?>

        <h3 class="header">Riepilogo giornaliero</h3>

        <h6>
        <a class="right-align btn-floating waves-effect waves-light red datepicker"><i class="material-icons">date_range</i></a>
        <?php

            if (isset($_GET['date'])) {
                echo "Riepilogo del " . dataLeggibile($_GET['date']);
            } else {
                // Codice date da https://www.mrwebmaster.it/php/data-oggi-italiano_11815.html

                // definisco due array arbitrarie
                $giorni = array("Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato");
                $mesi = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");

                // giorno della settimana in italiano
                $numero_giorno_settimana = date("w");
                $nome_giorno = $giorni[$numero_giorno_settimana];

                // giorno del mese
                $numero_giorno_mese = date("j");

                // nome del mese in italiano
                $numero_mese = date("n");
                $nome_mese = $mesi[$numero_mese - 1];

                // numero dell'anno
                $anno = date("Y");

                // Stampo a video
                echo "Oggi è " . $nome_giorno . " " . $numero_giorno_mese . " " . $nome_mese . " " . $anno;
            }
        ?>
        </h6>

        

        <hr>

        <?php for ($x = 0; $x < count($riepilogo); $x++) { ?>
            <div>
                <p class="riepilogo-titolo grey lighten-2"><b><?php echo $riepilogo[$x]['titolo'] ?></b></p>
                <blockquote>
                    <?php

                    $tipo = $riepilogo[$x]['tipo'];

                    // Promemoria
                    if ($tipo == 'PRO') {

                        echo linkCliccabili($riepilogo[$x]['dati']['desAnnotazioni']) . '<br>';
                        echo '<i>' . $riepilogo[$x]['dati']['desMittente'] . '</i>';

                        // Compiti assegnati
                    } else if ($tipo == 'COM') {

                        echo '<b>' . $riepilogo[$x]['dati']['desMateria'] . '</b> <br>';
                        echo linkCliccabili($riepilogo[$x]['dati']['desCompiti']) . '<br>';
                        echo '<i>' . $riepilogo[$x]['dati']['docente'] . '</i>';

                        // Argomenti lezione
                    } else if ($tipo == 'ARG') {

                        echo '<b>' . $riepilogo[$x]['dati']['desMateria'] . '</b> <br>';
                        echo linkCliccabili($riepilogo[$x]['dati']['desArgomento']) . '<br>';
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
                                <?php echo '<i class="circle ' . $vColor . '">' . $riepilogo[$x]['dati']['codVoto'] . '</i>';  ?>
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
        <?php } ?>

        <script>
            $(document).ready(function(){

                $('.datepicker').datepicker({
                    'autoClose': true,
                    'format': 'dd/mm/yyyy',
                    'defaultDate': new Date(<?= $datejsanno ?>, <?= $datejsmese ?>, <?= $datejsgiorno ?>),
                    // TODO: prendere le date automaticamente da schede di argoapi
                    'minDate': new Date(2019, 8, 1),
                    'maxDate': new Date(2020, 5, 30),
                    'setDefaultDate': true,
                    'onClose': function(){
                        var pickerval = $('.datepicker').val();
                        var date = pickerval.split('/');
                        var newDate = date[2] + '-' + date[1] + '-' + date[0];
                        console.log(newDate);
                        window.location.href = '?date=' + newDate
                    },
                    'i18n': {
                        'cancel': 'Annulla',
                        'clear': 'Cancella',
                        'done': 'Seleziona',
                        'months': [
                            'Gennaio',
                            'Febbraio',
                            'Marzo',
                            'Aprile',
                            'Maggio',
                            'Giugno',
                            'Luglio',
                            'Agosto',
                            'Settembre',
                            'Ottobre',
                            'Novembre',
                            'Dicembre'
                        ],
                        'monthsShort': [
                            'Gen',
                            'Feb',
                            'Mar',
                            'Apr',
                            'Mag',
                            'Giu',
                            'Lug',
                            'Ago',
                            'Set',
                            'Ott',
                            'Nov',
                            'Dic'
                        ],
                        'weekdays': [
                            'Lunedì',
                            'Martedì',
                            'Mercoledì',
                            'Giovedì',
                            'Venerdì',
                            'Sabato',
                            'Domenica'
                        ],
                        'weekdaysShort': [
                            'Lun',
                            'Mar',
                            'Mer',
                            'Gio',
                            'Ven',
                            'Sab',
                            'Dom'
                        ],
                        'weekdaysAbbrev': ['L', 'M', 'M', 'G', 'V', 'S', 'D']
                    }
                });
            });
        </script>

    </div>
</main>


<?php include './components/footer.php'; ?>
