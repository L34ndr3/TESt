<?php

class RequestSender {

	// envoi de la requête avec GET (récupération de données)
	public static function sendGetRequest($url_request) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROXY, '');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt(
			$ch,
			CURLOPT_HTTPHEADER,
			array(
				'Content-Type: application/json'
			)
		);
		$data = curl_exec($ch);
		if ($data === false) {
			$data = curl_error($ch);
		}

		$codeHttp = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);
		
		$reponse = ["data" => $data, "status_code_header" => $codeHttp];
	
		return $reponse;
	}

	// envoi de la requête avec POST (ajout de données), format des données : objet ou tableau php
	public static function sendPostRequest($url_request, $data_to_send) {

		$data_encoded = null;
		if ($data_to_send != null && (is_array($data_to_send) || is_object($data_to_send))) {
			$data_encoded = json_encode($data_to_send);
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_request);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_encoded);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROXY, '');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt(
			$ch,
			CURLOPT_HTTPHEADER,
			array(
				'Content-Type: application/json'
			)
		);

		$data = curl_exec($ch);
		if ($data === false) {
			$data = curl_error($ch);
		}

		$codeHttp = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);
		
		$reponse = ["data" => $data, "status_code_header" => $codeHttp];
		
		return $reponse;
	}

	// envoi de la requête avec DELETE (suppression)
	public static function sendDeleteRequest($url_request) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_request);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROXY, '');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt(
			$ch,
			CURLOPT_HTTPHEADER,
			array(
				'Content-Type: application/json'
			)
		);

		$data = curl_exec($ch);
		if ($data === false) {
			$data = curl_error($ch);
		}

		$codeHttp = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);
		
		$reponse = ["data" => $data, "status_code_header" => $codeHttp];
	
		return $reponse;
	}

	// envoi de la requête avec PUT (mise à jour), format des données : objet ou tableau php
	public static function sendPutRequest($url_request, $data_to_send) {

		$data_encoded = null;
		if ($data_to_send != null && (is_array($data_to_send) || is_object($data_to_send))) {
			$data_encoded = json_encode($data_to_send);
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_request);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_encoded);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROXY, '');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt(
			$ch,
			CURLOPT_HTTPHEADER,
			array(
				'Content-Type: application/json'
			)
		);

		$data = curl_exec($ch);
		if ($data === false) {
			$data = curl_error($ch);
		}

		$codeHttp = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);
		
		$reponse = ["data" => $data, "status_code_header" => $codeHttp];
		
		return $reponse;
	}
}
