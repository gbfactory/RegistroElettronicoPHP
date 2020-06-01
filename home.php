<?php include './components/header.php';

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

        <h3 class="header">Riepilogo giornaliero</h3>

        <h6>
            <a class="right-align btn-floating waves-effect waves-light red datepicker"><i class="material-icons">date_range</i></a>
            <?php

                if (isset($_GET['date'])) {
                    echo "Riepilogo del " . dataLeggibile($_GET['date']);
                } else {
                    // https://www.mrwebmaster.it/php/data-oggi-italiano_11815.html

                    $giorni = array("Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato");
                    $mesi = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");

                    $nome_giorno = $giorni[date("w")]; // giorno della settimana in italiano
                    $numero_giorno_mese = date("j"); // giorno del mese
                    $nome_mese = $mesi[date("n") - 1]; // nome del mese in italiano
                    $anno = date("Y"); // numero dell'anno

                    // Stampo a video
                    echo "Oggi è " . $nome_giorno . " " . $numero_giorno_mese . " " . $nome_mese . " " . $anno;
                }
            ?>
        </h6>

        <hr>

        <?php
        for ($x = 0; $x < count($riepilogo); $x++) {
            $tipo = $riepilogo[$x]['tipo']; ?>
                
            <?php // Promemoria
            if ($tipo == 'PRO') { ?>
                <div class="promemoria-header">
                    <p class="riepilogo-titolo valign-wrapper">
                        <b>Promemoria</b>
                        <a href="promemoria.php"><i class="material-icons">chevron_right</i></a>
                    </p>
                    <blockquote>
                        <?= linkCliccabili($riepilogo[$x]['dati']['desAnnotazioni']) ?> <br>
                        <i><?= $riepilogo[$x]['dati']['desMittente'] ?></i>
                    </blockquote>
                </div>

            <?php // Compiti assegnati
            } else if ($tipo == 'COM') { ?>
                <div class="promemoria-header">
                    <p class="riepilogo-titolo valign-wrapper">
                        <b>Compiti Assegnati</b>
                        <a href="compiti.php"><i class="material-icons">chevron_right</i></a>
                    </p>
                    <blockquote>
                        <b><?= $riepilogo[$x]['dati']['desMateria'] ?></b> <br>
                        <?= linkCliccabili($riepilogo[$x]['dati']['desCompiti']) ?> <br>
                        <i><?= $riepilogo[$x]['dati']['docente'] ?></i>
                    </blockquote>
                </div>

            <?php // Argomenti lezione
            } else if ($tipo == 'ARG') { ?>
                <div class="promemoria-header">
                    <p class="riepilogo-titolo valign-wrapper">
                        <b>Argomenti Lezione</b>
                        <a href="argomenti.php"><i class="material-icons">chevron_right</i></a>
                    </p>
                    <blockquote>
                        <b><?= $riepilogo[$x]['dati']['desMateria'] ?></b> <br>
                        <?= linkCliccabili($riepilogo[$x]['dati']['desArgomento']) ?> <br>
                        <i><?= $riepilogo[$x]['dati']['docente'] ?></i>
                    </blockquote>
                </div>

            <?php // Voto
            } else if ($tipo == 'VOT') {
                
                $codProva = $riepilogo[$x]['dati']['codVotoPratico'];
                $tipProva = '';
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
                <div class="promemoria-header">
                    <p class="riepilogo-titolo valign-wrapper">
                        <b>Voti Giornalieri</b>
                        <a href="voti.php"><i class="material-icons">chevron_right</i></a>
                    </p>
                    <blockquote>
                        <a class="btn-floating <?= $vColor ?>">
                            <i><?= $riepilogo[$x]['dati']['codVoto'] ?></i>
                        </a>
                        <span>
                            <b><?= $riepilogo[$x]['dati']['desMateria'] ?></b> <br>

                            <?php if ($riepilogo[$x]['dati']['desProva']) { ?>
                                <b>Descrizione:</b> <?= $riepilogo[$x]['dati']['desProva'] ?> <br>
                            <?php } ?>

                            <?php if ($riepilogo[$x]['dati']['desCommento']) { ?>
                                <b>Commento:</b> <?= $riepilogo[$x]['dati']['desCommento'] ?> <br>
                            <?php } ?>

                            <i><?= $riepilogo[$x]['dati']['docente'] ?></i>
                        </span>
                    </blockquote>
                </div>
                
            <?php // Bacheca    
            } else if ($tipo == 'BAC') { ?>
                <div class="promemoria-header">
                    <p class="riepilogo-titolo valign-wrapper">
                        <b>Bacheca</b>
                        <a href="bacheca.php"><i class="material-icons">chevron_right</i></a>
                    </p>
                    <blockquote>
                        <b><?= $riepilogo[$x]['dati']['desOggetto'] ?></b> <br>
                        <?= $riepilogo[$x]['dati']['desMessaggio'] ?>
                    </blockquote>
                </div>

            <?php // Note
            } else if ($tipo == 'NOT') { ?>
                <div class="promemoria-header">
                    <p class="riepilogo-titolo valign-wrapper">
                        <b>Note Disciplinari</b>
                        <a href="note.php"><i class="material-icons">chevron_right</i></a>
                    </p>
                    <blockquote>
                        <?= $riepilogo[$x]['dati']['desNota'] ?> <br>
                        <i><?= $riepilogo[$x]['dati']['docente'] ?></i>
                    </blockquote>
                </div>
            <?php } ?>
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
