<?php
    session_start();
    if (isset($_SESSION['authToken'])) {
        header('Location: home.php');
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Registro Elettronico</title>
    <link rel="shortcut icon" href="./assets/img/diary.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" media="screen,projection" />
    <style>
        /* Changing color background */
        .cambia-colore {
            background: linear-gradient(270deg, #b721ff, #21d4fd);
            background-size: 400% 400%;

            -webkit-animation: cambiacolore 7s ease infinite;
            -moz-animation: cambiacolore 7s ease infinite;
            -o-animation: cambiacolore 7s ease infinite;
            animation: cambiacolore 7s ease infinite;
        }

        @-webkit-keyframes cambiacolore {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @-moz-keyframes cambiacolore {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @-o-keyframes cambiacolore {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @keyframes cambiacolore {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
    </style>
</head>

<body class="cambia-colore">

    <div class="container">
        <div class="row">

            <form class="col m6 offset-m3 card" action="" method="POST">

                <div class="row center" style="margin-top: 30px;">
                    <img src="./assets/img/diary.svg" alt="" class="responsive-img" style="max-height: 150px">
                    <h5>Registro Elettronico</h5>
                    <p>Collegati ad Argo ScuolaNext con le tue credenziali</p>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">school</i>
                        <input id="codice_scuola" type="text" class="validate" name="codice">
                        <label for="codice_scuola">Codice Scuola</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="nome_utente" type="text" class="validate" name="utente">
                        <label for="nome_utente">Utente</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="password_utente" type="password" class="validate" name="password">
                        <label for="password_utente">Password</label>
                    </div>
                </div>

                <div class="row center">
                    <button class="btn waves-effect waves-light btn-large" type="submit" name="submit">Entra
                        <i class="material-icons right">send</i>
                    </button>
                </div>

                <?php

                if (isset($_POST['submit'])) {

                    require_once('./components/argoapi.php');

                    $error = '';

                    try {
                        $argo = new argoUser($_POST['codice'], $_POST['utente'], $_POST['password'], 0);

                        $_SESSION['codice'] = $_POST['codice'];
                        $_SESSION['utente'] = $_POST['utente'];
                        $_SESSION['tipo'] = $argo->tipoUtente;
                        $_SESSION['authToken'] = $argo->token;

                        header('Location: index.php');
                    } catch (Exception $e) {
                        echo '<div class="card-panel red">Errore di connessione alle API di Argo ' . $e->getMessage() . '</div>';
                    }
                } ?>

                <p>Questo non è il registro Argo ufficiale, per utilizzare il registro Argo ScuolaNext ufficiale recarsi a <a href="https://www.portaleargo.it/argoweb/famiglia/common/login_form2.jsp">questo link</a></p>

            </form>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>

</html>
