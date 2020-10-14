<?php

require '../config/Database.php';

	$sql = "SELECT * from books";

	if ($result = mysqli_query($conn, $sql))
	{
		$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		echo json_encode($data);
	}
	else
	{
		http_response_code(404);
	}
