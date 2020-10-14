<?php

require '../../config/Database.php';

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if(isset($postdata) && !empty($postdata))
{
	$userID = mysqli_real_escape_string($conn, trim($request->userID));

	$sql = "SELECT * from offers WHERE `userID` = '{$userID}'";

	if ($result = mysqli_query($conn, $sql))
	{
		$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		echo json_encode($data);
	}
	else
	{
		http_response_code(404);
	}
}