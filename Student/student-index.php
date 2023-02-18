<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginStudent'])) {
    header('Location:../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Dashboard</title>
</head>

<body>
    <a href="../login.php"><button type="button">Main Page</button></a>
    <a href="pay_fee.php"><button type="button">Pay Fee</button></a>
    <a href="stuProfile.php"><button type="button">Profile</button></a>

    <?php
    $stu_roll_no = $_SESSION['LoginStudent'];
    $query = "select * from student_record where roll_no = $stu_roll_no";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            $Student_name = $data['s_name'];
            $Student_class = $data['class'];
        }

    } else {
        echo 'No Data Available';
    }

    ?>

    <?php
    $query2 = "select * from timetable where day = 'tuesday' and class= '$Student_class'";

    $result2 = mysqli_query($connection, $query2);

    ?>

    <h1>Welcome
        <?php echo $Student_name; ?>
    </h1>

    <center>
        <h1>Your Daily Attendance</h1><br><br>

        <table cellpadding='8' width='60%'>
            <tr>
                <th>Date: 31/01/2023</th>
                <th>Roll No:
                    <?php echo $stu_roll_no; ?>
                </th>
                <th>Class:
                    <?php echo $Student_class; ?>
                </th>
            </tr>
        </table>
        <table border='1' cellpadding='5' width='60%'>

            <?php
            if (mysqli_num_rows($result2) > 0) {
                while ($data2 = mysqli_fetch_assoc($result2)) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $data2['subject_code'] . '<br>' . $data2['subject_name'] . '<br>' . $data2['faculty_name']; ?>
                        </td>
                        <td>
                            <?php echo $data2['time_slot'] . '<br>' . $data2['room_no']; ?>
                        </td>
                        <td>
                            <?php echo $data2['class']; ?>
                        </td>
                    </tr>

                    <?php
                }

            } else {
                echo 'No Data Available';
            }
            ?>
        </table>
    </center>


</body>

</html>