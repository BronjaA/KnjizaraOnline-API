<?php

require '../config/Database.php';

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if(isset($postdata) && !empty($postdata))
	{
		// Sanitize
		$userID = mysqli_real_escape_string($conn, trim($request->userID));
		$userOrder = mysqli_real_escape_string($conn, trim($request->userOrder));
		$ime = mysqli_real_escape_string($conn, trim($request->ime));
		$prezime = mysqli_real_escape_string($conn, trim($request->prezime));
		$ulica = mysqli_real_escape_string($conn, trim($request->ulica));
		$grad = mysqli_real_escape_string($conn, trim($request->grad));
		$zip = mysqli_real_escape_string($conn, trim($request->zip));
		$tel = mysqli_real_escape_string($conn, trim($request->tel));
		$email = mysqli_real_escape_string($conn, trim($request->email));
		$napomena = mysqli_real_escape_string($conn, trim($request->napomena));
		$status = mysqli_real_escape_string($conn, trim($request->status));


		// SQL upit
		$sql = "INSERT INTO orders(userID, userOrder, ime, prezime, ulica, grad, zip, tel, email, napomena, status) VALUES ('{$userID}','{$userOrder}','{$ime}','{$prezime}','{$ulica}','{$grad}','{$zip}','{$tel}','{$email}','{$napomena}','{$status}')";

		if($conn->query($sql) === TRUE)
		{
			$orders = [
				'userID'	=> $userID,
				'userOrder'	=> $userOrder,
				'ime'		=> $ime,
				'prezime'	=> $prezime,
				'ulica'		=> $ulica,
				'grad'		=> $grad,
				'zip'		=> $zip,
				'tel'		=> $tel,
				'email'		=> $email,
				'napomena'	=> $napomena,
				'status'	=> $status,
				'id'		=> mysqli_insert_id($conn) 
			];
			echo json_encode($orders);
		}
		else
		{
			http_response_code(404);
		}
	}