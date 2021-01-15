<?php
// Inizializza la sessione
session_start();

// Controlla se l'utente è loggato, in quel caso reindirizza al registro
if (isset($_SESSION['login'])) {
    header('Location: riepilogo.php');
    exit;
}

// Argo API
require_once('./components/argologin.php');

// Variabili
$codice = $utente = $password = '';
$errore = '';

// Quando il form di login viene inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controllo codice
    if (empty(trim($_POST['codice']))) {
        $errore .= 'Inserisci il codice scuola. ';
    } else {
        $codice = strtolower(trim($_POST['codice']));
    }

    // Controllo utente
    if (empty(trim($_POST['utente']))) {
        $errore .= 'Inserisci il nome utente. ';
    } else {
        $utente = strtolower(trim($_POST['utente']));
    }
    
    // Controllo password
    if (empty(trim($_POST['password']))) {
        $errore .= 'Inserisci il nome utente. ';
    } else {
        $password = strtolower(trim($_POST['password']));
    }

    // Procede se non ci sono errori
    if (empty($errore)) {
        try {
            $argo = new argoLogin($codice, $utente, $password);

            $_SESSION['codice'] = $codice;
            $_SESSION['authToken'] = $argo->__construct($codice, $utente, $password);

            header('Location: select.php');

            // $token = $argo->__construct($codice, $utente, $password);

            // header('Location: select.php?cod=' . $codice . '&token=' . $token);
        } catch (Exception $e) {
            $errore = 'Impossibile effettuare l\'accesso. Potrebbe essere un errore di credenziali o delle API di Argo.';
        }
    }
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

    <?php if (!empty($errore)) { ?>
        <div class="alert alert-danger" style="position: absolute; z-index: 9999; width: 100%;">
            <div class="container">
                <div class="alert-icon">
                    <i class="material-icons">error_outline</i>
                </div>
                <b>ERRORE:</b> <?= $errore; ?>
            </div>
        </div>
    <?php } ?>

    <div class="page-header header-filter" style="background-image: url('https://www.bing.com/<?= $json['images'][0]['url'] ?>'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                    <div class="card card-login">
                        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title">Registro Elettronico</h4>
                                <p class="text-center">Una nuova interfaccia web non ufficiale per il registro elettronico Argo Scuolanext.</p>
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">school</i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Codice Scuola" value="<?= $codice ?>" name="codice">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">account_circle</i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Nome Utente" value="<?= $utente ?>" name="utente">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">vpn_key</i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Password" value="<?= $password ?>" name="password">
                                </div>
                            </div>
                            <div class="footer text-center">
                                <button class="btn btn-primary" type="submit" name="submit">ACCEDI</button>
                                <p class="description text-center">Accedi al registro ufficiale da <a href="https://www.portaleargo.it/">portaleargo.it</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>