<?php

require '../../config/Database.php';

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if(isset($postdata) && !empty($postdata))
	{
		$from = "knjizara-online@bronjarmin.in.rs";

		// Sanitize
		$offerID = mysqli_real_escape_string($conn, trim($request->offerID));
		$status = mysqli_real_escape_string($conn, trim($request->status));
		$naziv = mysqli_real_escape_string($conn, trim($request->naziv));
		$autor = mysqli_real_escape_string($conn, trim($request->autor));
		$email = mysqli_real_escape_string($conn, trim($request->email));

		$to = $email;
		$subject = "Ponudjena knjiga";
		$message = "<div>Vaša ponuda za prodaju knjige: '" . $naziv . " - " . $autor . "' je upravo " . $status . ".</div><br> <br>Vaša Knjižara Online.";

		$headers = "From: " . $from . "\r\n";
		$headers .= "Reply-To: " . $from . "\r\n";
		$headers .= "Return-Path: " . $from . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";

		// SQL upit
		$sql = "UPDATE `offers` SET `statusPonude`='$status' WHERE `id` = '{$offerID}'";

		if($conn->query($sql) === TRUE)
		{
			mail($to, $subject, $message, $headers);
			http_response_code(200);
		}
		else
		{
			http_response_code(404);
		}
	}