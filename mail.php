<?php

$from = "knjizara-online@bronjarmin.in.rs";
$to = "arminb997@gmail.com";

$subject = "Ponudjena knjiga";
$message = "Ovo radi";

$headers = "From: " . $from . "\r\n";
$headers .= "Reply-To: " . $from . "\r\n";
$headers .= "Return-Path: " . $from . "\r\n";

mail($to, $subject, $message, $headers);

echo "Email uspesno poslat!";

?>