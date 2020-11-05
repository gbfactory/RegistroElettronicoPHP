<?php

session_start();

if (isset($_SESSION['login'])) {
} else {
    header('Location: index.php');
}

require_once('./components/argoapi.php');

$codice = $_SESSION['codice'];
$utente = $_SESSION['utente'];
$token = $_SESSION['authToken'];

try {
    $argo = new argoUser($codice, $utente, $token, 1);
} catch (Exception $e) {
    echo 'Errore di connessione ad ArgoAPI: ', $e->getMessage(), "\n";
    //header('Location: index.php');
}

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

<html>

<head>
    <meta charset="utf-8">
    <title>Registro Elettronico</title>
    <link rel="shortcut icon" href="./assets/img/diary.png" />
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
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Sei sicuro di voler uscire?</h4>
            <a class="waves-effect waves-light btn red darken-1 white-text" href="./logout.php">esci</a>
            <a class="waves-effect waves-light btn light-green darken-1 white-text" id="annulla">annulla</a>
        </div>
    </div>

    <script>
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $('#modal1').addClass('bottom-sheet');
        }

        $('#annulla').click(function() {
            $('#modal1').modal('close');
        })
    </script>

    <header>

        <nav>
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

            <div class="container switch right-align">
                <label>
                🌕
                <input type="checkbox" id="theme-switch">
                <span class="lever"></span>
                🌑
                </label>
            </div>
        </nav>

        <ul id="slide-out" class="sidenav sidenav-fixed">

            <li>
                <div class="user-view">
                    <div class="background"></div>
                    <a href="anagrafica"><span class="white-text name"><?= $headerArgo[0]['alunno']['desCognome'] ?> <?= $headerArgo[0]['alunno']['desNome'] ?></span></a>
                    <a href="anagrafica"><span class="white-text email"><?= $headerArgo[0]['desDenominazione'] ?><?= $headerArgo[0]['desCorso'] ?> <?= $headerArgo[0]['desSede'] ?></span></a>
                </div>
            </li>

            <li><a class="waves-effect" href="riepilogo">Riepilogo <span class="new badge red"><?= $eventi['nuoviElementi'] ?></span></a></li>

            <li><div class="divider"></div></li>

            <li><a class="subheader">Alunno</a></li>
            <li><a class="waves-effect" href="voti">Voti Giornalieri</a></li>
            <li><a class="waves-effect" href="assenze">Assenze Giornaliere</a></li>
            <li><a class="waves-effect" href="note">Note Disciplinari</a></li>
            <li><a class="waves-effect" href="scrutinio">Voti Scrutinio</a></li>

            <li><div class="divider"></div></li>

            <li><a class="subheader">Classe</a></li>
            <li><a class="waves-effect" href="compiti">Compiti Assegnati</a></li>
            <li><a class="waves-effect" href="argomenti">Argomenti Lezione</a></li>
            <li><a class="waves-effect" href="promemoria">Promemoria Classe</a></li>
            <li><a class="waves-effect" href="orario">Orario Classe</a></li>
            <li><a class="waves-effect" href="">Ricevimento Docenti</a></li>
            <li><a class="waves-effect" href="docenti">Docenti Classe</a></li>
            <li><a class="waves-effect" href="bacheca">Bacheca</a></li>

            <li><div class="divider"></div></li>

            <li><a class="subheader">Documenti</a></li>
            <li><a class="waves-effect" href="documenti">Documenti alunno</a></li>
            <li><a class="waves-effect" href="condivisione">Documenti docenti</a></li>
            <li><a class="waves-effect" href="anagrafica">Dati anagrafici</a></li>

            <li><div class="divider"></div></li>
            
            <li><a class="waves-effect red darken-1 white-text modal-trigger" href="#modal1">Logout</a></li>

        </ul>

    </header>
