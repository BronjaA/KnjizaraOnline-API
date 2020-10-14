<?php

require '../../config/Database.php';

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if(isset($postdata) && !empty($postdata))
	{
		// Sanitize
		$userID = mysqli_real_escape_string($conn, trim($request->userID));
		$naziv = mysqli_real_escape_string($conn, trim($request->naziv));
		$autor = mysqli_real_escape_string($conn, trim($request->autor));
		$izdavac = mysqli_real_escape_string($conn, trim($request->izdavac));
		$brStrana = mysqli_real_escape_string($conn, trim($request->brStrana));
		$pismo = mysqli_real_escape_string($conn, trim($request->pismo));
		$povez = mysqli_real_escape_string($conn, trim($request->povez));
		$format = mysqli_real_escape_string($conn, trim($request->format));
		$gIzdanja = mysqli_real_escape_string($conn, trim($request->gIzdanja));
		$napomena = mysqli_real_escape_string($conn, trim($request->napomena));
		$stanje = mysqli_real_escape_string($conn, trim($request->stanje));
		$cena = mysqli_real_escape_string($conn, trim($request->cena));
		$ime = mysqli_real_escape_string($conn, trim($request->ime));
		$ulica = mysqli_real_escape_string($conn, trim($request->ulica));
		$zip = mysqli_real_escape_string($conn, trim($request->zip));
		$grad = mysqli_real_escape_string($conn, trim($request->grad));
		$tel = mysqli_real_escape_string($conn, trim($request->tel));
		$email = mysqli_real_escape_string($conn, trim($request->email));

		// SQL upit
		$sql = "INSERT INTO offers(userID, naziv, autor, izdavac, brStrana, pismo, povez, format, gIzdanja, napomena, stanje, cena, ime, ulica, zip, grad, tel, email) VALUES ('{$userID}','{$naziv}','{$autor}','{$izdavac}','{$brStrana}','{$pismo}','{$povez}','{$format}','{$gIzdanja}','{$napomena}','{$stanje}','{$cena}', '{$ime}', '{$ulica}', '{$zip}', '{$grad}', '{$tel}', '{$email}')";

		if($conn->query($sql) === TRUE)
		{
			http_response_code(200);
		}
		else
		{
			http_response_code(404);
		}
	}