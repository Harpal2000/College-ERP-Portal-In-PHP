<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginStudent'])) {
    header('Location:login.php');
}

$rollNO = $_POST['rollNO'];

if (isset($_POST['payment_status']) && $_POST['payment_status'] == 'success') {
    $query = "UPDATE fee_payment_record SET status = 'paid' WHERE roll_no = $rollNO";
    $result = mysqli_query($connection, $query);
    if ($result) {
        echo "Database updated";
    } else {
        echo "Error updating database";
    }
} else {
    echo "Invalid payment status";
}


?>