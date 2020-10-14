<?php

require '../config/Database.php';
	
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if(isset($postdata) && !empty($postdata))
	{
		// Sanitize - cistimo unos od nedozvoljenih karaktera
		$username = mysqli_real_escape_string($conn, trim($request->username));
		$password = mysqli_real_escape_string($conn, trim($request->password));
		$email = mysqli_real_escape_string($conn, trim($request->email));

		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		$sql = "SELECT * from user WHERE `email`='{$email}'";
		$regUser = null;

		if($result = mysqli_query($conn, $sql))
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$regUser['email'] = $row['email'];
				$regUser['username'] = $row['username'];
				$regUser['password'] = $row['password'];
			}

			if($regUser != Null)
			{	// ukoliko je nasao nalog koji koristi istu email adresu
				http_response_code(400);
				echo json_encode(
		        array(
		            "message" => "Već postoji nalog sa unetom E-Mail adresom!"
		        ));

			}else{
				// ako je uneo dobru email adresu treba da kreira nalog
				$sql = "INSERT INTO user(username, password, email) VALUES ('{$username}','{$hashed_password}','{$email}')";

				if(mysqli_query($conn, $sql))
				{
					$from = "knjizara-online@bronjarmin.in.rs";
					$to = $email;

					$subject = "Registracija naloga";
					$message = "<div>Uspešno ste dodali nalog.</div>" . "<br> <br>Završite proces registracije tako što ćete potvrditi E-Mail adresu " . "<a href='https://bronjarmin.in.rs/users/verifyEmail.php?email=$email&pass=$hashed_password'>KLIKOM NA OVAJ LINK</a>";

					$headers = "From: " . $from . "\r\n";
					$headers .= "Reply-To: " . $from . "\r\n";
					$headers .= "Return-Path: " . $from . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        			$headers .= 'MIME-Version: 1.0' . "\r\n";

        			mail($to, $subject, $message, $headers);
        			http_response_code(200);

        			echo json_encode(
		        	array(
		            	"message" => "Uspešno ste kreirali nalog! Potvrdite svoju E-Mail adresu da bi mogli da ga koristite."
		        	));
				}
				else{
					http_response_code(404);
				}
			}
		}
	}