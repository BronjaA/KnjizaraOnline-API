<?php

//Varijable
define('DB_HOST', 'localhost');
define('DB_USER', 'bronjarm_armin');
define('DB_PASS', 'armin');
define('DB_NAME', 'bronjarm_knjizaraonline');

//funkcija koja povezuje s bazom i vraca conn
function connect()
{
  $connect = mysqli_connect(DB_HOST ,DB_USER ,DB_PASS ,DB_NAME);

  if (mysqli_connect_errno($connect)) {
    die("Failed to connect:" . mysqli_connect_error());
  }

  mysqli_set_charset($connect, "utf8");

  return $connect;
}

$conn = connect();