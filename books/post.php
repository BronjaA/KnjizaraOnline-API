<?php

require '../config/Database.php';

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if(isset($postdata) && !empty($postdata))
	{
		// Sanitize
		$autor = mysqli_real_escape_string($conn, trim($request->autor));
		$ime = mysqli_real_escape_string($conn, trim($request->ime));
		$cena = mysqli_real_escape_string($conn, trim($request->cena));
		$kategorija = mysqli_real_escape_string($conn, trim($request->kategorija));
		$slika = mysqli_real_escape_string($conn, trim($request->slika));
		$izdavac = mysqli_real_escape_string($conn, trim($request->izdavac));
		$brStrana = mysqli_real_escape_string($conn, trim($request->brStrana));
		$pismo = mysqli_real_escape_string($conn, trim($request->pismo));
		$povez = mysqli_real_escape_string($conn, trim($request->povez));
		$format = mysqli_real_escape_string($conn, trim($request->format));
		$gIzdanja = mysqli_real_escape_string($conn, trim($request->gIzdanja));
		$opis = mysqli_real_escape_string($conn, trim($request->opis));

		// SQL upit
		$sql = "INSERT INTO books(autor, ime, cena, kategorija, slika, izdavac, brStrana, pismo, povez, format, gIzdanja, opis) VALUES ('{$autor}','{$ime}','{$cena}','{$kategorija}','{$slika}','{$izdavac}','{$brStrana}','{$pismo}','{$povez}','{$format}','{$gIzdanja}','{$opis}')";

		if($conn->query($sql) === TRUE)
		{
			$book = [
				'autor'		=> $autor,
				'ime'		=> $ime,
				'cena'		=> $cena,
				'kategorija'=> $kategorija,
				'slika'		=> $slika,
				'izdavac'	=> $izdavac,
				'brStrana'	=> $brStrana,
				'pismo'		=> $pismo,
				'povez'		=> $povez,
				'format'	=> $format,
				'gIzdanja'	=> $gIzdanja,
				'opis'		=> $opis,
				'id'		=> mysqli_insert_id($conn) 
			];
			echo json_encode($book);
		}
		else
		{
			http_response_code(404);
		}
	}