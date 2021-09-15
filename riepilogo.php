<?php
$cod = "rpg";
$titolo = "Riepilogo Giornaliero";

include './components/header.php';

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

$data = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");

$riepilogo = $argo->oggiScuola($date);
?>

<main>
    <div class="container">

        <div class="row">
            <div class="col s12 m8">
                <div class="section">
                    <?php if (empty($riepilogo)) { ?>
                        <div class="center not-found">
                            <img class="responsive-img" width="500px" height="auto" src="./img/not_found.svg" alt="Not Found">
                            <h5>In questa data non è successo nulla...</h5>
                        </div>
                    <?php } ?>

                    <?php
                    // Array tipi evento
                    $voti = [];
                    $assenze = [];
                    $compiti = [];
                    $argomenti = [];
                    $note = [];
                    $promemoria = [];
                    $bacheca = [];


                    for ($x = 0; $x < count($riepilogo); $x++) {
                        switch ($riepilogo[$x]['tipo']) {
                            case 'VOT':
                                array_push($voti, $riepilogo[$x]);
                                break;
                            case 'ASS':
                                array_push($assenze, $riepilogo[$x]);
                                break;
                            case 'COM':
                                array_push($compiti, $riepilogo[$x]);
                                break;
                            case 'ARG':
                                array_push($argomenti, $riepilogo[$x]);
                                break;
                            case 'NOT':
                                array_push($note, $riepilogo[$x]);
                                break;
                            case 'PRO':
                                array_push($promemoria, $riepilogo[$x]);
                                break;
                            case 'BAC':
                                array_push($bacheca, $riepilogo[$x]);
                                break;
                            default:
                                break;
                        }
                    }

                    ?>

                    <?php if (count($voti) > 0) { ?>
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>Voti Giornalieri</h5>
                            </li>
                            <?php for ($x = 0; $x < count($voti); $x++) { ?>
                                <?php $item = $voti[$x]['dati']; ?>
                                <li class="collection-item avatar">
                                    <i class="circle <?= coloreVoto($item['decValore']) ?>"><?= $item['codVoto'] ?></i>

                                    <span class="title"><?= $item['desMateria'] ?>
                                        <?php if (substr($item['desCommento'], -14) == '(non fa media)') echo '<b>(Non fa media)</b>'; ?>
                                    </span>

                                    <p><?= dataLeggibile($item['datGiorno']) ?> - <?= tipoProva($codProva = $item['codVotoPratico']) ?></p>

                                    <p><?php if ($item['desProva'] != '') echo ('<b>Descrizione:</b> ' . $item['desProva']); ?>

                                    <p><?php if ($item['desCommento'] != '') echo ('<b>Commento:</b> ' . $item['desCommento']); ?>

                                    <p><i><?= rimuovi_parentesi($item['docente']); ?></i></p>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>


                    <?php if (count($assenze) > 0) { ?>
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>Assenze Giornaliere</h5>
                            </li>
                            <?php for ($x = 0; $x < count($assenze); $x++) { ?>
                                <?php $item = $assenze[$x]['dati']; ?>
                                <li class="collection-item avatar">

                                    <?php if ($item['codEvento'] == 'A') { ?>
                                        <i class="circle material-icons red darken-4">close</i>
                                        <span class="title">Assenza del <b><?= dataLeggibile($item['datAssenza']) ?></b></span>
                                        <p>Registrata da <?= rimuovi_parentesi($item['registrataDa']) ?></p>

                                    <?php } else if ($item['codEvento'] == 'I') { ?>
                                        <i class="circle material-icons green darken-3">subdirectory_arrow_right</i>
                                        <span class="title">Ingresso del <b><?= dataLeggibile($item['datAssenza']) ?></b> in <b><?= $item['numOra'] ?>° ora</b></span>
                                        <p>Ingresso alle ore <?= substr($item['oraAssenza'], -5) ?> registrato da <?= rimuovi_parentesi($item['registrataDa']) ?></p>

                                    <?php } else if ($item['codEvento'] == 'U') { ?>
                                        <i class="circle material-icons orange darken-4">subdirectory_arrow_left</i>
                                        <span class="title">Uscita del <b><?= dataLeggibile($item['datAssenza']) ?></b> in <b><?= $item['numOra'] ?>° ora</b></span>
                                        <p>Uscita alle ore <?= substr($item['oraAssenza'], -5) ?> registrata da <?= rimuovi_parentesi($item['registrataDa']) ?></p>
                                    <?php } ?>

                                    <?php if (isset($item['giustificataDa'])) { ?>
                                        <p>Giustificata da <?= rimuovi_parentesi($item['giustificataDa']) ?> il <?= dataLeggibile($item['datGiustificazione']) ?>
                                        <?php } else { ?>
                                        <p>Da giustificare!</p>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php if (count($compiti) > 0) { ?>
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>Compiti Assegnati</h5>
                            </li>
                            <?php for ($x = 0; $x < count($compiti); $x++) { ?>
                                <?php $item = $compiti[$x]['dati']; ?>
                                <li class="collection-item avatar">
                                    <i class="material-icons circle <?= colore_data($item['datCompiti']) ?>">book</i>

                                    <b class="title"><?= $item['desMateria'] ?></b>

                                    <p>Assegnati per il <b><?= dataLeggibile($item['datCompiti']) ?></b></p>

                                    <p><?= linkCliccabili(explode('(Assegnati per il', $item['desCompiti'])[0]) ?></p>

                                    <p><i><?= rimuovi_parentesi($item['docente']) ?></i></p>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php if (count($argomenti) > 0) { ?>
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>Argomenti Lezioni</h5>
                            </li>
                            <?php for ($x = 0; $x < count($argomenti); $x++) { ?>
                                <?php $item = $argomenti[$x]['dati']; ?>
                                <li class="collection-item avatar">
                                    <i class="material-icons circle blue darken-2">reorder</i>

                                    <b class="title"><?= $item['desMateria'] ?></b>

                                    <p><?= linkCliccabili($item['desArgomento']) ?></p>

                                    <p><i><?= rimuovi_parentesi($item['docente']) ?></i></p>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php if (count($note) > 0) { ?>
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>Note disciplinari</h5>
                            </li>
                            <?php for ($x = 0; $x < count($note); $x++) { ?>
                                <?php $item = $note[$x]['dati']; ?>
                                <li class="collection-item avatar">
                                    <i class="material-icons circle red">new_releases</i>

                                    <span class="title">Nota del <?= dataLeggibile($item['datNota']) ?> (<?= substr($item['oraNota'], -5) ?>)</span>

                                    <?php if ($item['flgVisualizzata'] != 'S') {
                                        echo ('<a class="secondary-content tooltipped" data-position="top" data-tooltip="Non è stata presa visione!"><i class="material-icons">error_outline</i></a>');
                                    } ?>

                                    <p><?= $item['desNota'] ?></p>

                                    <p><i><?= $item['docente'] ?></i></p>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php if (count($promemoria) > 0) { ?>
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>Promemoria</h5>
                            </li>
                            <?php for ($x = 0; $x < count($promemoria); $x++) { ?>
                                <?php $item = $promemoria[$x]['dati']; ?>
                                <li class="collection-item avatar">
                                    <i class="material-icons circle <?= colore_data($item['datGiorno']) ?>">announcement</i>

                                    <p><?= linkCliccabili($item['desAnnotazioni']) ?></p>

                                    <p><i><?= $item['desMittente'] ?></i></p>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php if (count($bacheca) > 0) { ?>
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>Bacheca</h5>
                            </li>
                            <?php for ($x = 0; $x < count($bacheca); $x++) { ?>
                                <?php $item = $bacheca[$x]['dati']; ?>
                                <li class="collection-item avatar">
                                    <i class="material-icons circle">date_range</i>

                                    <b class="title"><?= $item['desOggetto'] ?></b>

                                    <p><?= $item['desMessaggio'] ?></p>

                                    <?php for ($i = 0; $i < count($item['allegati']); $i++) { ?>
                                        <p class="valign-wrapper"><i class="material-icons" style="margin-right: .5rem">attachment</i>
                                            <a href="bacheca.php"><?= $item['allegati'][$i]['desFile'] ?></a>
                                        </p>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="section">
                    <div class="card">
                        <div class="card-content flow-text">
                            <?= data_bella($data) ?>
                        </div>
                    </div>

                    <a class="waves-effect waves-light btn red datepicker" style="width: 100%"><i class="material-icons left">date_range</i>cambia data</a>

                </div>
            </div>

        </div>
    </div>
</main>

<script>
    $(document).ready(function() {

        $('.datepicker').datepicker({
            'autoClose': true,
            'format': 'dd/mm/yyyy',
            'defaultDate': new Date(<?= $datejsanno ?>, <?= $datejsmese ?>, <?= $datejsgiorno ?>),
            // // TODO: prendere le date automaticamente da schede di argoapi
            // 'minDate': new Date(2020, 8, 1),
            // 'maxDate': new Date(2021, 5, 30),
            'setDefaultDate': true,
            'onClose': function() {
                var pickerval = $('.datepicker').val();
                var date = pickerval.split('/');
                var newDate = date[2] + '-' + date[1] + '-' + date[0];
                
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

<?php include './components/footer.php'; ?>