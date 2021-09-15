<?php
session_start();

if (!isset($_GET['scheda']) || !isset($_SESSION['codice']) || !isset($_SESSION['utente']) || !isset($_SESSION['authToken'])) {
    header('Location: index.php');
    exit;
}

$_SESSION['scheda'] = $_GET['scheda'];

header('Location: riepilogo.php');
exit;