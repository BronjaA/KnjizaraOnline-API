<?php

require '../config/Database.php';
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if(isset($postdata) && !empty($postdata))
	{
		http_response_code(200);
		$secret_key = "997puslicatorta3107";
		$jwt = mysqli_real_escape_string($conn, trim($request->jwt));

		//dekoduje jwt na osnovu jwt koji sam poslao i secret key-a
		$decoded = JWT::decode($jwt, $secret_key, array('HS256'));

		echo json_encode(
			array(
				"userID" => $decoded->data->id
			));
	}