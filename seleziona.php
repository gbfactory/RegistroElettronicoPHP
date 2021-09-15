<?php
session_start();

if (!isset($_SESSION['codice']) || !isset($_SESSION['utente']) || !isset($_SESSION['authToken'])) {
    header('Location: index.php');
    exit;
}

$codice = $_SESSION['codice'];
$utente = $_SESSION['utente'];
$token = $_SESSION['authToken'];

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleziona Utente - Registro Elettronico</title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/pure-min.css" integrity="sha384-Uu6IeWbM+gzNVXJcM9XV3SohHtmWE+3VGi496jvgX1jyvDTXfdK+rfZc8C1Aehk5" crossorigin="anonymous">

    <style>
        html {
            background-color: #1f8dd6;
        }

        body {
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .selettore {
            background-color: #fff;
            border-radius: 6px;
            padding: 1.5rem;
        }

        h1 {
            margin-top: 0;
        }

        h3 {
            margin: 0;
        }

        span {
            display: inline-block;
            margin: .3rem 0 .8rem 0;
        }
        .utente {
            margin-bottom: 1.5rem;
        }

        img {
            height: 100px;
            width: 100px;
            margin-right: 1rem;
        }

        .button-error {
            background: rgb(202, 60, 60);
            color: #fff;
        }

        .titoletto h1,
        .titoletto a {
            display: inline-block;
        }

        .titoletto a {
            float: right;
        }
    </style>
</head>

<body>

    <div class="selettore">
        <div class="titoletto">
            <h1>Seleziona Utente</h1>
            <a class="button-error pure-button" href="riepilogo.php">Annulla</a>
        </div>

        <?php
        $header = array("x-auth-token: " . $token, "x-cod-min: " . $codice);
        $curl = curl("schede", $header);

        if ($curl['httpcode'] == 200) {
            $res = json_decode($curl['output'], true);



            for ($i = 0; $i < count($res); $i++) {
                $user = $res[$i];
        ?>
            <div class="utente pure-g">
            <div class="pure-u-1-3">
                <img alt="User" src="./img/user.png">
            </div>

            <div class="pure-u-2-3">
                <h3><?= $user['alunno']['desNome'] ?> <?= $user['alunno']['desCognome'] ?></h3>
                <span><?= $user['desDenominazione'] ?> - <?= $user['desCorso'] ?> - <?= $user['desSede'] ?> </span>
                <a class="pure-button pure-button-primary" href="selezionaScheda.php?scheda=<?= $i; ?>">Seleziona Utente</a>
            </div>
        </div>

        <?php
            }
        } else {
            echo 'errore';
            $errore = TRUE;
        }

        ?>

    </div>
</body>

</html>