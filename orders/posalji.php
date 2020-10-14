<?php

require '../config/Database.php';

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if(isset($postdata) && !empty($postdata))
	{
		$from = "knjizara-online@bronjarmin.in.rs";

		// Sanitize
		$orderID = mysqli_real_escape_string($conn, trim($request->orderID));
		$datum = mysqli_real_escape_string($conn, trim($request->datum));
		$suma = mysqli_real_escape_string($conn, trim($request->suma));
		$email = mysqli_real_escape_string($conn, trim($request->email));
		$status = mysqli_real_escape_string($conn, trim($request->status));

		$to = $email;
		$subject = "Porudžbina - Knjižara Online";
		$message = "<div>Vaša porudžbina u iznosu od " . $suma . ".00 RSD, na datum: " . $datum . " je upravo promenila status u - " . $status . ".</div><br> <br>Za više informacija potražite kontakt na našem sajtu.<br>Vaša Knjižara Online.";

		$headers = "From: " . $from . "\r\n";
		$headers .= "Reply-To: " . $from . "\r\n";
		$headers .= "Return-Path: " . $from . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
		// SQL upit
		$sql = "UPDATE `orders` SET `status`='$status' WHERE `id` = '{$orderID}'";

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