<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "booku";

    $koneksi = mysqli_connect($host,$user,$pass,$db);
    if(!$koneksi){
        die ("Tidak Terkoneksi");
    }
?>