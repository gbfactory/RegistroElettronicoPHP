<?php
session_start();

if (isset($_SESSION['codice']) || isset($_SESSION['utente']) || isset($_SESSION['authToken'])) {

    if (!isset($_SESSION['scheda'])) {
        header('Location: seleziona.php');
        exit;
    }

    header('Location: riepilogo.php');
    exit;
}

function curl($request, $auxiliaryHeader, $auxiliaryQuery = array()) {
    $defaultHeader = array(
        "x-key-app: " . "ax6542sdru3217t4eesd9",
        "x-version: " . "2.1.0",
        "x-produttore-software: " . "ARGO Software s.r.l. - Ragusa",
        "x-app-code: " . "APF",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36"
    );

    $header = array_merge($defaultHeader, $auxiliaryHeader);

    $defaultQuery = array("_dc" => round(microtime(true) * 1000));
    $query = array_merge($defaultQuery, $auxiliaryQuery);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.portaleargo.it/famiglia/api/rest/" . $request . "?" . http_build_query($query));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $output = curl_exec($ch);

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return array("output" => $output, "httpcode" => $httpcode);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codice = $_POST['codice'];
    $user = $_POST['utente'];
    $password = $_POST['password'];

    $header = array("x-cod-min: " . $codice, "x-user-id: " . $user, "x-pwd: " . $password);
    $curl = curl("login", $header);

    if ($curl['httpcode'] == 200) {
        $curl = json_decode($curl['output']);
        $token = $curl->token;

        $header = array("x-auth-token: " . $token, "x-cod-min: " . $codice);
        $curl = curl("schede", $header);

        if ($curl['httpcode'] == 200) {
            $curl = ((array) json_decode($curl['output']));

            if (count($curl) <= 1) {
                // Se c'è solo 1 scheda manda a riepilogo
                $_SESSION['codice'] = $codice;
                $_SESSION['utente'] = $user;
                $_SESSION['authToken'] = $token;
                $_SESSION['scheda'] = 0;

                header('Location: riepilogo.php');
                exit;

            } else {
                // Se ci sono più schede manda a selettore
                $_SESSION['codice'] = $codice;
                $_SESSION['utente'] = $user;
                $_SESSION['authToken'] = $token;

                header('Location: seleziona.php');
                exit;
            }
        } else {
            $errore = TRUE;
        }

    } else {
        $errore = TRUE;
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

    <?php if ($error === TRUE) { ?>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            swal.fire({
                icon: 'error',
                title: 'Accesso fallito!',
                text: 'Controlla le tue credenziali o riprova più tardi.',
            })
        </script>
    <?php } ?>

    <?php include './components/analyticstracking.php' ?>

</body>

</html>