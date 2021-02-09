<?php

session_start();

if (!isset($_SESSION['login']) || !isset($_SESSION['codice']) || !isset($_SESSION['utente']) || !isset($_SESSION['authToken'])) {
    header('Location: logout.php');
    exit;
}

require_once('./components/argoapi.php');

$codice = $_SESSION['codice'];
$utente = $_SESSION['utente'];
$token = $_SESSION['authToken'];

try {
    $argo = new argoUser($codice, $utente, $token, 1);
} catch (Exception $e) {
    header('Location: logout.php');
    exit;
}

if (!isset($titolo) || !isset($cod)) {
    $titolo = $cod = "";
}

$active_class = 'class="nav-active"';

$argoLink = 'http://www.' . $codice . '.scuolanext.info/';

$headerArgo = $argo->schede();
$eventi = $argo->conteggioEventi(date('Y-m-d'));

$codAlunno = $headerArgo[0]['prgAlunno'];

// Data leggibile
function dataLeggibile($data) {
    $dataSplit = explode('-', $data);
    return $dataSplit[2] . '/' . $dataSplit[1] . '/' . $dataSplit[0];    
}

// Link cliccabili https://stackoverflow.com/questions/5341168/best-way-to-make-links-clickable-in-block-of-text
function linkCliccabili($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
}

// Nice name
function rimuovi_parentesi($nome) {
    return str_replace(['(', ')'], '', $nome);
}

// Colore in base alla data
function colore_data($data) {
    $oggi = date('Y-m-d');

    if ($data > $oggi) {
        return 'yellow';
    } else if ($data < $oggi) {
        return 'green';
    } else if ($data == $oggi) {
        return 'red';
    }
}

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

function coloreGrafico($voto) {
    if ($voto <= 1) {
        return '183, 28, 28';
    } else if (($voto >= 1) && ($voto < 5)) {
        return '244, 67, 54';
    } else if (($voto >= 5) && ($voto < 6)) {
        return '230, 81, 0';
    } else if (($voto >= 6) && ($voto < 7)) {
        return '205, 220, 57';
    } else if (($voto >= 7) && ($voto < 8)) {
        return '175, 180, 43';
    } else if (($voto >= 8) && ($voto < 9)) {
        return '139, 195, 74';
    } else if (($voto >= 9) && ($voto < 10)) {
        return '76, 175, 80';
    } else if ($voto >= 10) {
        return '56, 142, 60';
    }
}

function tipoProva($cod, $tipo = false) {
    if ($cod == 'S') {
        return $tipo ? 'Scritta' : 'Scritto';
    } else if ($cod == 'N') {
        return 'Orale';
    } else if ($cod == 'P') {
        return $tipo ? 'Pratica' : 'Pratico';
    }
}

function tipoEvento($cod) {
    if ($cod == 'A') {
        return 'Assenza';
    } else if ($cod == 'I') {
        return 'Ingresso';
    } else if ($cod == 'U') {
        return 'Uscita';
    }
}

function data_bella($data) {
    // Conversione data
    $data = strtotime($data);

    // Array con nomi mesi e giorni
    $giorni = array("Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato");
    $mesi = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");

    // Ottiene le informazioni a partire dalla data fornita
    $nome_giorno = $giorni[date("w", $data)];
    $giorno = date("j", $data);
    $nome_mese = $mesi[date("n", $data) - 1];
    $anno = date("Y", $data);

    // Stampa
    return $nome_giorno . " " . $giorno . " " . $nome_mese . " " . $anno;
}

?>

<!DOCTYPE html>

<html lang="it">

<head>
    <meta charset="utf-8">
    <title><?= $titolo ?> - Registro</title>
    <link rel="shortcut icon" href="./img/icon.png" />
    <meta name="description" content="Interfaccia registro elettronico Argo ScuolaNext">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/dark.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    
</head>

<body>

    <!-- Logout modal -->
    <div id="modal_settings" class="modal">
        <div class="modal-content">
            <h4>Impostazioni</h4>
            <hr>
            <h5>Dark Mode</h5>
            <div class="container switch">
                <label>
                🌕
                <input type="checkbox" id="theme-switch">
                <span class="lever"></span>
                🌑
                </label>
            </div>
            <hr>
            <a class="waves-effect waves-light btn red darken-1 white-text" id="settings_close">chiudi</a>
        </div>
    </div>

    <!-- Logout modal -->
    <div id="modal_logout" class="modal">
        <div class="modal-content">
            <h4>Sei sicuro di voler uscire?</h4>
            <a class="waves-effect waves-light btn red darken-1 white-text" href="./logout.php">esci</a>
            <a class="waves-effect waves-light btn light-green darken-1 white-text" id="logout_cancel">annulla</a>
        </div>
    </div>

    <script>
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $('#modal_logout').addClass('bottom-sheet');
            $('#modal_settings').addClass('bottom-sheet');
        }

        $('#logout_cancel').click(function() {
            $('#modal_logout').modal('close');
        })
        
        $('#settings_close').click(function() {
            $('#modal_settings').modal('close');
        })
    </script>

    <header>

        <nav class="top-nav">
            <div class="container">
                <div class="nav-wrapper">
                    <div class="row">
                        <div class="col s12">
                            <h3 class="header"><?= $titolo ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-target="slide-out" class="top-nav sidenav-trigger full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <ul id="slide-out" class="sidenav sidenav-fixed">
            <li>
                <div class="user-view">
                    <div class="background"></div>
                    <a href="anagrafica.php"><span class="white-text name"><?= $headerArgo[0]['alunno']['desCognome'] ?> <?= $headerArgo[0]['alunno']['desNome'] ?></span></a>
                    <a href="anagrafica.php"><span class="white-text email"><?= $headerArgo[0]['desDenominazione'] ?><?= $headerArgo[0]['desCorso'] ?> <?= $headerArgo[0]['desSede'] ?></span></a>
                </div>
            </li>

            <li <?= $cod == "rpg" ? $active_class : "" ?>><a class="waves-effect" href="riepilogo.php">Riepilogo <span class="new badge red"><?= $eventi['nuoviElementi'] ?></span></a></li>
            <li <?= $cod == "agd" ? $active_class : "" ?>><a class="waves-effect" href="agenda.php">Agenda</a></li>

            <li><div class="divider"></div></li>

            <li><a class="subheader">Alunno</a></li>
            <li <?= $cod == "vot" ? $active_class : "" ?>><a class="waves-effect" href="voti.php">Voti Giornalieri</a></li>
            <li <?= $cod == "ass" ? $active_class : "" ?>><a class="waves-effect" href="assenze.php">Assenze Giornaliere</a></li>
            <li <?= $cod == "not" ? $active_class : "" ?>><a class="waves-effect" href="note.php">Note Disciplinari</a></li>
            <li <?= $cod == "vsc" ? $active_class : "" ?>><a class="waves-effect" href="scrutinio.php">Voti Scrutinio</a></li>

            <li><div class="divider"></div></li>

            <li><a class="subheader">Classe</a></li>
            <li <?= $cod == "com" ? $active_class : "" ?>><a class="waves-effect" href="compiti.php">Compiti Assegnati</a></li>
            <li <?= $cod == "arg" ? $active_class : "" ?>><a class="waves-effect" href="argomenti.php">Argomenti Lezione</a></li>
            <li <?= $cod == "pro" ? $active_class : "" ?>><a class="waves-effect" href="promemoria.php">Promemoria Classe</a></li>
            <li <?= $cod == "ora" ? $active_class : "" ?>><a class="waves-effect" href="orario.php">Orario Classe</a></li>
            <li <?= $cod == "ric" ? $active_class : "" ?>><a class="waves-effect" href="ricevimento.php">Ricevimento Docenti</a></li>
            <li <?= $cod == "prf" ? $active_class : "" ?>><a class="waves-effect" href="docenti.php">Docenti Classe</a></li>
            <li <?= $cod == "bac" ? $active_class : "" ?>><a class="waves-effect" href="bacheca.php">Bacheca</a></li>

            <li><div class="divider"></div></li>

            <li><a class="subheader">Documenti</a></li>
            <li <?= $cod == "dal" ? $active_class : "" ?>><a class="waves-effect" href="documenti.php">Documenti alunno</a></li>
            <li <?= $cod == "ddo" ? $active_class : "" ?>><a class="waves-effect" href="condivisione.php">Documenti docenti</a></li>
            <li <?= $cod == "ang" ? $active_class : "" ?>><a class="waves-effect" href="anagrafica.php">Dati anagrafici</a></li>

            <li><div class="divider"></div></li>

            <li><a class="waves-effect green white-text modal-trigger" href="#modal_settings">Impostazioni</a></li>

            <li><div class="divider"></div></li>

            <li><a class="waves-effect red darken-1 white-text modal-trigger" href="#modal_logout">Logout</a></li>
        </ul>

    </header>