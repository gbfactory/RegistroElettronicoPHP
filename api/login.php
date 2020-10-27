<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
header("Access-Control-Allow-Headers: x-cod-min, x-user-id, x-pwd");
header("Content-Type: application/json; charset=UTF-8");

$getHeaders = getallheaders();
$codMin = $getHeaders['x-cod-min'];
$userId = $getHeaders['x-user-id'];
$passwd = $getHeaders['x-pwd'];

// print $codMin;
// print $userId;
// print $passwd;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.portaleargo.it/famiglia/api/rest/login");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
  'x-key-app: ax6542sdru3217t4eesd9',
  'x-version: 2.1.0',
  'x-produttore-software: ARGO Software s.r.l. - Ragusa',
  'x-app-code: APF',
  'x-cod-min: ' . $codMin,
  'x-user-id: ' . $userId,
  'x-pwd: ' . $passwd,
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$server_output = curl_exec ($ch);

curl_close ($ch);

echo json_encode($server_output);