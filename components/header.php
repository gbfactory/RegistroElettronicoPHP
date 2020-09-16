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

// Data leggibile
function dataLeggibile($data) {
    $dataSplit = explode('-', $data);
    return $dataSplit[2] . '/' . $dataSplit[1] . '/' . $dataSplit[0];    
}

// Link cliccabili https://stackoverflow.com/questions/5341168/best-way-to-make-links-clickable-in-block-of-text
function linkCliccabili($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
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
        </nav>

        <ul id="slide-out" class="sidenav sidenav-fixed">

            <li>
                <div class="user-view">
                    <div class="background grey darken-1"></div>
                    <a href="anagrafica.php"><span class="white-text name"><?= $headerArgo[0]['alunno']['desCognome'] ?> <?= $headerArgo[0]['alunno']['desNome'] ?></span></a>
                    <a href="anagrafica.php"><span class="white-text email"><?= $headerArgo[0]['desDenominazione'] ?><?= $headerArgo[0]['desCorso'] ?> <?= $headerArgo[0]['desSede'] ?></span></a>
                </div>
            </li>

            <li><a class="waves-effect" href="home.php">Riepilogo</a></li>

            <li><div class="divider"></div></li>

            <li><a class="subheader">Alunno</a></li>
            <li><a class="waves-effect" href="anagrafica.php">Dati Anagrafici</a></li>
            <li><a class="waves-effect" href="voti.php">Valutazioni</a></li>
            <li><a class="waves-effect" href="assenze.php">Assenze</a></li>
            <li><a class="waves-effect" href="note.php">Note Disciplinari</a></li>

            <li><div class="divider"></div></li>

            <li><a class="subheader">Classe</a></li>
            <li><a class="waves-effect" href="compiti.php">Compiti Assegnati</a></li>
            <li><a class="waves-effect" href="argomenti.php">Argomenti Lezione</a></li>
            <li><a class="waves-effect" href="promemoria.php">Promemoria</a></li>
            <li><a class="waves-effect" href="orario.php">Orario Scolastico</a></li>
            <li><a class="waves-effect" href="docenti.php">Docenti Classe</a></li>

            <li><div class="divider"></div></li>

            <li><a class="subheader">Documenti</a></li>
            <li><a class="waves-effect" href="bacheca.php">Bacheca</a></li>
            <li><a class="waves-effect" href="documenti.php">Bacheca Alunno</a></li>

            <li><div class="divider"></div></li>
            
            <li><a class="waves-effect" href="app.html">App</a></li>
            <li><a class="waves-effect red darken-1 white-text modal-trigger" href="#modal1">Logout</a></li>

        </ul>

    </header>
