<?php

require '../config/Database.php';

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['pass']) && !empty($_GET['pass'])){
    
    $email=$_GET['email'];
    $password=$_GET['pass'];
    
    $verified='true';
    
    $sql = "UPDATE `user` SET `verified`='$verified' WHERE `email` = '{$email}' AND `password`='{$password}'";

    if (mysqli_query($conn, $sql)) {
        echo '<h1>Čestitamo! Uspešno ste potvrdili E-Mail adresu!</h1>';
    } else {
        echo '<h1>Verifikacija neuspešna!</h1>';
    }
}else{
    echo 'Došlo je do greške.';
}