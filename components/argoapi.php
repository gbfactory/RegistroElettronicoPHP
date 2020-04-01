<?php

// Part of the code is from: https://github.com/cristianlivella/ArgoAPI

define("ARGOAPI_URL", "https://www.portaleargo.it/famiglia/api/rest/");
define("ARGOAPI_KEY", "ax6542sdru3217t4eesd9");
define("ARGOAPI_VERSION", "2.1.0");
define("ARGOAPI_COMPANY", "ARGO Software s.r.l. - Ragusa");
define("ARGOAPI_CODE", "APF");

define("datGiorno", date("Y-m-d"));

class argoUser {
	
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
    

	public function __construct($cod_min, $username, $password, $loginwithtoken = 0) {

		if ($loginwithtoken==0) {

			$header = array("x-cod-min: ".$cod_min, "x-user-id: ".$username, "x-pwd: ".$password);
			$curl = $this->curl("login", $header);

			if ($curl['httpcode']==200) {
				$this->username = $username;
				$curl = json_decode($curl['output']);
				$token = $curl->token;
				$header = array("x-auth-token: ".$token, "x-cod-min: ".$cod_min);
				$curl = $this->curl("schede", $header);

				if ($curl['httpcode']==200) {
					$curl = ((array) json_decode($curl['output'])[0]);
					foreach ($curl as $thisKey => $thisCurl) {
						$this->$thisKey = $thisCurl;
					}
				} else {
					throw new Exception("Impossibile ottenere info utente");
				}

			} else {
				throw new Exception("Login fallito");
			}

		} elseif ($loginwithtoken==1) {

			$this->username = $username;
			$token = $password;
			$header = array("x-auth-token: ".$token, "x-cod-min: ".$cod_min);
			$curl = $this->curl("schede", $header);

			if ($curl['httpcode']==200) {
				$curl = ((array) json_decode($curl['output'])[0]);
				foreach ($curl as $thisKey => $thisCurl) {
					$this->$thisKey = $thisCurl;
				}
			}
			else {
				throw new Exception("Login con token fallito");
			}

		}
		
    }	
    
	// Schede (Dati anagrafici studente)
    public function schede() {
        $header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin);
		$curl = $this->curl("schede", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true);
		} else {
			throw new Exception("Errore");
		}
    }

	// Oggi a scuola (Resoconto della giornata)
	public function oggiScuola($datGiorno = datGiorno) {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$query = array("datGiorno" => $datGiorno);
		$curl = $this->curl("oggi", $header, $query);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
    }
    
	// Assenze
	public function assenze() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("assenze", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
    }
    

	// Note disciplinari
	public function noteDisciplinari() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("notedisciplinari", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
    }
    

	// Voti giornalieri
	public function votiGiornalieri() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("votigiornalieri", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
    }
    

	// Voti scrutinio
	public function votiScrutinio() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("votiscrutinio", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true);
		} else {
			throw new Exception("Errore");
		}
    }
    

	// Compiti
	public function compiti() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("compiti", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
    }
    

	// Argomenti lezioni
	public function argomenti() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("argomenti", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
    }
    

	// Promemoria
	public function promemoria() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("promemoria", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
    }
    

	// Orario
	public function orario() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("orario", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
    }
    

	// Docenti
	public function docenti() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("docenticlasse", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true);
		} else {
			throw new Exception("Errore");
		}
	}
	
	// Bacheca
	public function bacheca() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("bachecanuova", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
	}
	
	public function bachecaalunno() {
		$header = array("x-auth-token: ".$this->authToken, "x-cod-min: ".$this->codMin, "x-prg-alunno: ".$this->prgAlunno, "x-prg-scheda: ".$this->prgScheda, "x-prg-scuola: ".$this->prgScuola);
		$curl = $this->curl("bachecaalunno", $header);
		if ($curl['httpcode']==200) {
			return json_decode($curl['output'], true)['dati'];
		} else {
			throw new Exception("Errore");
		}
	}

}
