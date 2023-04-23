<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginTeacher'])) {
    echo "<script>alert('session break')</script>";
    header('Location:../login.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Teacher Dashboard</title>
</head>

<body>
    <a href="../login.php"><button type="button">Main Dashboard</button></a>
    <a href="../stuAtt.php?t_name=<?php echo $_SESSION['LoginTeacher']; ?>"><button type="button">Daily
            Attendance</button></a>

    <h1>Welcome
        <?php echo $_SESSION['LoginTeacher']; ?>
    </h1>

    <center>
        <h1> Time Table </h1>
        <?php
        $teacher_name = $_SESSION['LoginTeacher'];
        $query = "SELECT * FROM `timetable` WHERE faculty_name = '$teacher_name'";

        $result = mysqli_query($connection, $query);

        ?>

        <table border='1' cellpadding='10'>
            <tr>
                <td>Sr No.</td>
                <td>Subject Code</td>
                <td>Subject Name</td>
                <td>Time Slot</td>
                <td>Day</td>
                <td>Room No.</td>
                <td>Subject Type</td>
                <td>Class</td>
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
                            <?php echo $data['subject_code']; ?>
                        </td>
                        <td>
                            <?php echo $data['subject_name']; ?>
                        </td>
                        <td>
                            <?php echo $data['start_time'] . " - " . $data['end_time']; ?>
                        </td>
                        <td>
                            <?php echo $data['lec_day']; ?>
                        </td>
                        <td>
                            <?php echo $data['room_no']; ?>
                        </td>
                        <td>
                            <?php echo $data['subject_type']; ?>
                        </td>
                        <td>
                            <?php echo $data['class']; ?>
                        </td>
                    </tr>

                    <?php
                }
            } else {
                echo "No Data Found!";
            }
            ?>
        </table><br><br>
    </center>
</body>

</html>