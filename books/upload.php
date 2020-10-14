<?php
require '../config/Database.php';

	if($_FILES){

		$target_dir = "images/";
		echo $target_file = $target_dir . basename($_FILES['slika']['name']);
		move_uploaded_file($_FILES['slika']['tmp_name'], $target_file);
		echo $file_name = $_FILES['slika']['name'];
	}
?>