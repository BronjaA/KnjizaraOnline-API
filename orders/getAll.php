<?php

require '../config/Database.php';

$order = [];
$sql = "SELECT * from orders ORDER BY datum DESC";

if($result = mysqli_query($conn, $sql))
{
	$cr = 0;
	while($row = mysqli_fetch_assoc($result))
	{	
		$order[$cr]['id'] 			= $row['id'];
		$order[$cr]['userID']		= $row['userID'];
		$order[$cr]['userOrder']	= $row['userOrder'];
		$order[$cr]['ime']			= $row['ime'];
		$order[$cr]['prezime']		= $row['prezime'];
		$order[$cr]['ulica']		= $row['ulica'];
		$order[$cr]['grad']			= $row['grad'];
		$order[$cr]['zip']			= $row['zip'];
		$order[$cr]['tel']			= $row['tel'];
		$order[$cr]['email']		= $row['email'];
		$order[$cr]['napomena']		= $row['napomena'];
		$order[$cr]['status']		= $row['status'];
		$order[$cr]['datum']		= $row['datum'];

		$korpa = [];
		$string = explode(';', $row['userOrder']);

		$i = 0;
		foreach($string as $pom)
		{
			$stavka = explode(',', $pom);

			$kvantitet 	= $stavka[0];
			$bookID 	= isset($stavka[1]) ? $stavka[1] : null;
			$bookPrice	= isset($stavka[2]) ? $stavka[2] : null;

			$sql2 = "SELECT * from books WHERE `id` = '{$bookID}'";
			if($result2 = mysqli_query($conn, $sql2))
			{
				while($row2 = mysqli_fetch_assoc($result2))
				{
					$korpa[$i]['kvantitet'] 	= $kvantitet;
					$korpa[$i]['id'] 			= $row2['id'];
					$korpa[$i]['autor'] 		= $row2['autor'];
					$korpa[$i]['ime'] 			= $row2['ime'];
					$korpa[$i]['cena'] 			= $bookPrice;
					$korpa[$i]['kategorija'] 	= $row2['kategorija'];
					$korpa[$i]['slika'] 		= $row2['slika'];
					$korpa[$i]['izdavac'] 		= $row2['izdavac'];
					$korpa[$i]['brStrana'] 		= $row2['brStrana'];
					$korpa[$i]['pismo'] 		= $row2['pismo'];
					$korpa[$i]['povez'] 		= $row2['povez'];
					$korpa[$i]['format'] 		= $row2['format'];
					$korpa[$i]['gIzdanja'] 		= $row2['gIzdanja'];
					$korpa[$i]['opis'] 			= $row2['opis'];
				}
				
			}else{
				http_respones_code(404);
			}
			$i++;
		}
		$order[$cr]['korpa'] = $korpa;
		$cr++;
	}
	echo json_encode(['data' => $order]);
}else{
	http_response_code(404);
}