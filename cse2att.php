<?php

require 'connection.php';

session_start();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Teacher Dashboard</title>
</head>

<body>
    <a href="login.php"><button type="button">Main Page</button></a>
    <a href="teachDash.php"><button type="button">My Dashboard</button></a>
    <a href="stuAtt.php"><button type="button">Daily Attendance</button></a>


    <center>
        <h1>Your Today's Attendance</h1>
        <?php
        $query = "SELECT * FROM `student_record` WHERE class = 'CSE2'";

        $result = mysqli_query($connection, $query);

        ?>

        <table border='1' cellpadding='10'>
            <tr>
                <td>Sr No.</td>
                <td>Student Name</td>
                <td>Student E-mail</td>
                <td>Absent/Present</td>
            </tr>

            <?php
            $sr_no = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    ?>

                    <tr>
                        <td>
                            <?php echo $sr_no; ?>
                        </td>
                        <?php $sr_no = $sr_no + 1 ?>
                        <td>
                            <?php echo $data['s_name']; ?>
                        </td>
                        <td>
                            <?php echo $data['s_pass']; ?>
                        </td>
                        <td>
                            <form method="POST" action="">
                                <input type="radio" name="radio" value="present">

                        </td>
                    </tr>

                    <?php
                }
            } else {
                echo "No Data Found!";
            }
            ?>
        </table><br><br>
        <input type="submit" name="s-att-data" id="s-att-data" value="Next">
        </form>

        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['s-att-data'])) {

            if (!empty($_POST['radio'])) {

                $select_lec = $_POST['radio'];
                echo $select_lec;

            } else {
                echo "Error!";
            }

        } 


        ?>
    </center>
</body>

</html>