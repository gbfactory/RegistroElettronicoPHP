<?php
// Inizializza la sessione
session_start();

// Controlla se l'utente è loggato, in quel caso reindirizza al registro
if (isset($_SESSION['login'])) {
    header('Location: riepilogo.php');
    exit;
}

// Argo API
require_once('./components/argoschede.php');

// Torna all'index se mancano i dati
if (!isset($_SESSION['codice']) || !isset($_SESSION['authToken'])) {
    header('Location: index.php');
    exit;
}

// Variabili dati
$codice = $_SESSION['codice'];
$token = $_SESSION['authToken'];

// Recupera dati
$utenti;

try {
    $argo = new argoSchede($codice, $token);

    $utenti = $argo->__construct($codice, $token);
} catch (Exception $e) {
    $errore = 'Errore durante l\'ottenimento degli utenti.';
}

// Quando il form di login viene inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_code = $_POST['user_code'];

    $_SESSION['login'] = true;
    $_SESSION['userCode'] = $user_code;

    header('Location: riepilogo.php');
    exit;
}

// Sfondo immagine Bing
$file = file_get_contents("https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=en-US");
$json = json_decode($file, true);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="https://scuola.gbfactory.net/img/icon.png">
    <link rel="icon" type="image/png" href="https://scuola.gbfactory.net/img/icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Registro Elettronico</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://scuola.gbfactory.net/" />
    <!--  Social tags      -->
    <meta name="keywords" content="registro elettronico, registro online, argo, argo scuolanext, argo famiglia">
    <meta name="description" content="Una nuova interfaccia web non ufficiale per il Registro Elettronico Argo Scuolanext.">
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Registro Elettronico">
    <meta itemprop="description" content="Una nuova interfaccia web non ufficiale per il Registro Elettronico Argo Scuolanext.">
    <meta itemprop="image" content="https://i.imgur.com/X1eCKpK.png">
    <!-- Open Graph data -->
    <meta property="og:title" content="Registro Elettronico" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://scuola.gbfactory.net/" />
    <meta property="og:image" content="https://i.imgur.com/X1eCKpK.png" />
    <meta property="og:description" content="Una nuova interfaccia web non ufficiale per il Registro Elettronico Argo Scuolanext." />
    <meta property="og:site_name" content="Registro Elettronico" />
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-kit/2.0.6/css/material-kit.min.css" integrity="sha512-maBfUe6UBMwSa9YhA4MKGi7M/KMBw8KEt5HsqKHWNXCST1qzjlNgxOCP7M+eNRI2T/JQpWRUHI8quTNhWTTKtQ==" crossorigin="anonymous" />
</head>

<body class="login-page sidebar-collapse">

    <div class="page-header header-filter" style="background-image: url('https://www.bing.com/<?= $json['images'][0]['url'] ?>'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 ml-auto mr-auto">
                    <div class="card card-login">
                        <div class="card-header card-header-primary text-center">
                            <h4 class="card-title">Seleziona Utente</h4>
                            <p class="text-center">Seleziona l'utente con cui accedere al registro.</p>
                        </div>

                        <div class="card-body">
                            <?php for ($i = 0; $i < count($utenti); $i++) { ?>
                                <?php $utente = $utenti[$i]; ?>
                                <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="card card-nav-tabs">
                                        <div class="card-body">
                                            <h4 class="card-title"><?= $utente['alunno']['desNome'] ?> <?= $utente['alunno']['desCognome'] ?></h4>
                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                            <input type="hidden" name="user_code" value="<?= $i ?>">
                                            <button class="btn btn-primary" type="submit">Accedi con questo utente</button>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>