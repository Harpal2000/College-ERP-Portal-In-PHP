<?php

$server_name = 'localhost';
$user_name = 'root';
$password = '';
$data_base = 'demo2';

$connection = mysqli_connect($server_name, $user_name, $password, $data_base);

if (!$connection) {
    die("Could not connect");
}

?>