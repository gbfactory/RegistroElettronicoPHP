<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: *');
header("Content-Type: application/json; charset=UTF-8");

$getHeaders = getallheaders();
$codMin = $getHeaders['x-cod-min'];
$token = $getHeaders['x-auth-token'];
$alunno = $getHeaders['x-prg-alunno'];
$scheda = $getHeaders['x-prg-scheda'];
$scuola = $getHeaders['x-prg-scuola'];

$api = $_GET['api'];

$url = "https://www.portaleargo.it/famiglia/api/rest/" . $api;

if ($api == "oggi") $url .= "?datGiorno=" . $_GET['datGiorno'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
  'x-key-app: ax6542sdru3217t4eesd9',
  'x-version: 2.1.0',
  'x-produttore-software: ARGO Software s.r.l. - Ragusa',
  'x-app-code: APF',
  'x-cod-min: ' . $codMin,
  'x-auth-token: ' . $token,
  'x-prg-alunno: ' . $alunno,
  'x-prg-scheda: ' . $scheda,
  'x-prg-scuola: ' . $scuola,
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$server_output = curl_exec ($ch);

curl_close ($ch);

echo json_encode($server_output);