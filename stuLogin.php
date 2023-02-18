<?php 

require 'connection.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Login</title>
</head>

<body>
    <a href="records.php"><button type="button">All Records</button></a><br><br>
    <a href="index.php"><button type="button">Main Page</button></a><br><br>
    <a href="teachReg.php"><button type="button">Teacher Register</button></a></a><br><br>
    <center>
        <div id="regForm">
            <h1>Student's Login Here</h1>
            <form action="" method="POST">
                <table cellpadding='10'>
                    <tr>
                        <td>Enter Username:</td>
                        <td><input type="text" name="s_username" id="s_username"></td>
                    </tr>

                    <tr>
                        <td>Enter Password:</td>
                        <td><input type="password" name="s_password" id="s_password"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="s-btn" id="s-btn" value="Login">
                        </td>
                    </tr>
            </form>
        </div>
    </center>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['s-btn'])) {
        $s_username = $_POST['s_username'];
        $s_password = $_POST['s_password'];

        $Query = "SELECT * FROM `userdata` WHERE u_name = '$s_username'";
        echo $Query;

        $s_result = mysqli_query($connection, $Query);
        if (mysqli_num_rows($s_result) > 0) {
            while ($stuData = mysqli_fetch_assoc($s_result)) {
                if ($s_username == $stuData['u_name'] && $s_password == $stuData['u_pass']) {
                    $_SESSION['s_username'] = $s_username;
                    header('Location:stuDash.php');
                } else {
                    echo "<script>alert('Invalid username and password!');
                            </script>";
                }
            }

        } else {
            echo "Error: " . $Query . "<br>" . mysqli_error($Connection);
        }
    }

    ?>
</body>

</html>