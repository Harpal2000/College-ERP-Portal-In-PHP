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
            $Student_group = $data['s_group'];
        }

    } else {
        echo 'No Data Available';
    }

    ?>


    <?php
    $query2 = "SELECT * FROM timetable WHERE lec_day = 'monday' AND class = '$Student_class' AND class_group = '$Student_group' OR (lec_sch = 'combine' AND lec_day = 'monday' AND class = '$Student_class')";


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
                <th>Group:
                    <?php echo $Student_group; ?>
                </th>
            </tr>
        </table>
        <table border='1' cellpadding='5' width='60%'>
            <th>Subject Name</th>
            <th>Teacher Name</th>
            <th>Time-Slot</th>
            <th>Day</th>
            <th>Attendance</th>
            <th>Total Attendance/Total Delivered</th>

            <?php
            if (mysqli_num_rows($result2) > 0) {
                while ($data2 = mysqli_fetch_assoc($result2)) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $data2['subject_name'] . ' [ ' . $data2['subject_code'] . ']' . " <br> " . ' ( ' . $data2['subject_type'] . ' )' . ' ( ' . $data2['room_no'] . ' )'; ?>
                        </td>
                        <td>
                            <?php echo $data2['faculty_name']; ?>
                        </td>
                        <td>
                            <?php echo $data2['start_time'] . " - " . $data2['end_time']; ?>
                        </td>
                        <td>
                            <?php echo $data2['lec_day']; ?>
                        </td>
                        <td style="text-align:center; vertical-align:middle;">
                            <?php
                            $sub_id = $data2['id'];
                            $query_att = "select * from attendance_record where sub_id = '$sub_id' and stu_roll_no = '$stu_roll_no'";

                            $result_att = mysqli_query($connection, $query_att);

                            $total_present = 0;
                            if (mysqli_num_rows($result_att) > 0) {
                                while ($data2 = mysqli_fetch_assoc($result_att)) {
                                    if ($data2['att_status'] == '') {
                                        echo 'N/A';
                                    } else if ($data2['att_status'] == 'Absent' or $data2['att_status'] == 'Present') {
                                        if ($data2['att_status'] == 'Present') {
                                            $total_present++;
                                        }
                                        echo $data2['att_status'];
                                    } else {
                                        echo 'No Data Found';
                                    }
                                }
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td style="text-align:center; vertical-align:middle;">
                            <?php
                            $query_lec = "select * from attendance_record where sub_id = '$sub_id' and stu_roll_no = '$stu_roll_no'";

                            $result_lec = mysqli_query($connection, $query_lec);
                            if (mysqli_num_rows($result_lec) > 0) {
                                while ($data2 = mysqli_fetch_assoc($result_lec)) {
                                    $delivered_lec = $data2['lec_no'];
                                    echo "$total_present" . "/" . "$delivered_lec";
                                }
                            } else {
                                echo 'N/A';
                            }
                            ?>
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