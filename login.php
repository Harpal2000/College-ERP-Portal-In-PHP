<?php

require 'connection.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Teacher Login</title>
</head>

<body>
    <a href="teachReg.php"><button type="button">Teacher Register</button></a></a>
    <a href="login.php"><button type="button">Main Dashboard</button></a></a>
    <br><br><br><br>
    <center>
        <div id="regForm" style="margin-top: 5rem;">
            <h1>Login To Dashboard</h1>
            <form action="" method="POST">
                <table cellpadding='10'>
                    <tr>
                        <td>Enter Username:</td>
                        <td><input type="text" name="username" id="username"></td>
                    </tr>

                    <tr>
                        <td>Enter Password:</td>
                        <td><input type="password" name="password" id="password"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="login" id="login" value="Login">
                        </td>
                    </tr>
            </form>
        </div>
    </center>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $Query = "select * from login where username = '$user' and password = '$pass'";
        echo $Query;

        $result = mysqli_query($connection, $Query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row["role"] == "Admin") {
                    $_SESSION['LoginAdmin'] = $row["username"];
                    header('Location: ../admin/admin-index.php');

                } else if ($row["role"] == "Teacher" and $row["account"] == "Activate") {
                    $_SESSION['LoginTeacher'] = $row["username"];
                    header('Location: ../teacher/teachDash.php');

                } else if ($row["role"] == "Student" and $row["account"] == "Activate") {
                    $_SESSION['LoginStudent'] = $row['username'];
                    header('Location: ../student/student-index.php');
                }
            }

        } else {
            echo "Error: " . $Query . "<br>" . mysqli_error($Connection);
        }
    }

    ?>
</body>

</html>