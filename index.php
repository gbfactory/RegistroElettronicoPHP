<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: riepilogo.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('./components/argoapi.php');

    $error = '';

    try {
        $argo = new argoUser($_POST['codice'], $_POST['utente'], $_POST['password'], 0);

        $_SESSION['login'] = true;
        $_SESSION['codice'] = $_POST['codice'];
        $_SESSION['utente'] = $_POST['utente'];
        $_SESSION['authToken'] = $argo->schede()[0]['authToken'];

        header('Location: riepilogo.php');
        exit;
    } catch (Exception $e) {
        echo '<div class="card-panel red">Errore di connessione alle API di Argo ' . $e->getMessage() . '</div>';
    }
}

$file = file_get_contents("https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=en-US");
$json = json_decode($file, true);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="./img/icon.png">
    <link rel="icon" type="image/png" href="./img/icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Registro Elettronico</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://registro.gbfactory.net/" />
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
    <meta property="og:url" content="https://registro.gbfactory.net/" />
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
                                    <input type="text" class="form-control" placeholder="Codice Scuola" name="codice">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">account_circle</i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Nome Utente" name="utente">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">vpn_key</i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Password" name="password">
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

    <?php include './components/analyticstracking.php' ?>
</body>

</html>