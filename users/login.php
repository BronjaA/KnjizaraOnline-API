<?php

require '../config/Database.php';
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if(isset($postdata) && !empty($postdata))
	{
		$password = mysqli_real_escape_string($conn, trim($request->password));
		$email = mysqli_real_escape_string($conn, trim($request->email));

		$sql = "SELECT * FROM user WHERE `email`='{$email}'";

		$loggedInUser = null;

		if($result = mysqli_query($conn, $sql))
		{
			while($row = mysqli_fetch_assoc($result))	//ovo grabi jedan row iz niza koji je dobio iz sql upita. Ovo assoc znaci da je associative
			{
				$loggedInUser['id'] = $row['id'];
				$loggedInUser['username'] = $row['username'];
				$loggedInUser['password'] = $row['password'];
				$loggedInUser['verified'] = $row['verified'];
			}

			if($loggedInUser == Null)
			{
				http_response_code(400);
            	echo json_encode(
                	array(
                    	"message" => "Nalog na koji pokušavate da se prijavite ne postoji.",
                	)
            	);
			}

			else if($loggedInUser['verified'] == 'false')
			{
				http_response_code(400);
            	echo json_encode(
                	array(
                    	"message" => "Pristup odbijen. Molimo Vas potvrdite svoju E-Mail adresu da bi se prijavili.",
                	)
            	);
			}

			else if(password_verify($password, $loggedInUser['password']))
			{
				$secret_key = "997puslicatorta3107";
		        $issuer_claim = "broxss"; // this can be the servername
		        $audience_claim = "korisnici";
		        $issuedat_claim = time(); // issued at
		        $notbefore_claim = $issuedat_claim + 1; //not before in seconds
		        $expire_claim = $issuedat_claim + 604800; // expire time in seconds
		        $token = array(
		            "iss" => $issuer_claim,
		            "aud" => $audience_claim,
		            "iat" => $issuedat_claim,
		            "nbf" => $notbefore_claim,
		            "exp" => $expire_claim,
		            "data" => array(
		                "id" => $loggedInUser['id'],
		                "username" => $loggedInUser['username']
		        ));

		        http_response_code(200);

		        $jwt = JWT::encode($token, $secret_key);
		        echo json_encode(
		            array(
		                "message" => "Prijava uspešna!",
		                "jwt" => $jwt,
		                "username" => $loggedInUser['username'],
		                "email" => $email,
		                "expireAt" => $expire_claim
		            ));
			}
			else {
				http_response_code(400);
				echo json_encode(
		            array(
		                "message" => "Uneta E-Mail adresa ili šifra nisu tačne."
		            ));
			}

		}
		else
		{
			http_response_code(404);
		}
	}