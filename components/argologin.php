<?php

// Part of the code is from: https://github.com/cristianlivella/ArgoAPI

define("ARGOAPI_URL", "https://www.portaleargo.it/famiglia/api/rest/");
define("ARGOAPI_KEY", "ax6542sdru3217t4eesd9");
define("ARGOAPI_VERSION", "2.1.0");
define("ARGOAPI_COMPANY", "ARGO Software s.r.l. - Ragusa");
define("ARGOAPI_CODE", "APF");

define("datGiorno", date("Y-m-d"));

class argoLogin {
	
	private function curl($request, $auxiliaryHeader, $auxiliaryQuery = array()) {
		$defaultHeader = array("x-key-app: ".ARGOAPI_KEY, "x-version: ".ARGOAPI_VERSION, "x-produttore-software: ".ARGOAPI_COMPANY, "x-app-code: ".ARGOAPI_CODE, "user-agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36");
		$header = array_merge($defaultHeader, $auxiliaryHeader);
		$defaultQuery = array("_dc" => round(microtime(true) * 1000));
		$query = array_merge($defaultQuery, $auxiliaryQuery);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, ARGOAPI_URL.$request."?".http_build_query($query));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$output = curl_exec ($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return array("output" => $output, "httpcode" => $httpcode);
    }
    

	public function __construct($cod_min, $username, $password) {
        $header = array("x-cod-min: ".$cod_min, "x-user-id: ".$username, "x-pwd: ".$password);
        $curl = $this->curl("login", $header);

        if ($curl['httpcode']==200) {
            $this->username = $username;
            $curl = json_decode($curl['output'], true);
            return $curl['token'];
        } else {
            throw new Exception("Login fallito");
        }
    }

}
