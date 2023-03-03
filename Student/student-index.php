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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Student Dashboard</title>
    <style>
        table {
            width: 80% !important;
        }
    </style>
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

    <center>
        <h1>Your Daily Attendance</h1><br><br>

        <table cellpadding='8' class="table">
            <tr>
                <?php
                $current_date = date("d-m-Y");
                ?>
                <th>Date:
                    <?php echo $current_date ?>
                </th>
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
        <table cellpadding='6' class="table table-striped">
            <th>S No</th>
            <th>Subject Name</th>
            <th>Teacher Name</th>
            <th>Time-Slot</th>
            <th>Day</th>
            <th>Attendance</th>
            <th>Total Attendance/Total Delivered</th>
            <th>Total Attendance %</th>

            <?php
            $i = 1;
            if (mysqli_num_rows($result2) > 0) {
                while ($data2 = mysqli_fetch_assoc($result2)) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $i++ ?>
                        </td>
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
                            $current_date = date("Y-m-d");
                            $query_att = "select * from attendance_record where sub_id = '$sub_id' and stu_roll_no = '$stu_roll_no' and att_date = '$current_date'";

                            $result_att = mysqli_query($connection, $query_att);

                            $total_present = 0;
                            if (mysqli_num_rows($result_att) > 0) {
                                while ($data2 = mysqli_fetch_assoc($result_att)) {
                                    if ($data2['att_status'] == '') {
                                        echo 'N/A';
                                    } else if ($data2['att_status'] == 'Absent' or $data2['att_status'] == 'Present') {
                                        if ($data2['att_status'] == 'Present') {
                                            ?>
                                                <button type="button" class="btn btn-success btn-sm">
                                                <?php echo $data2['att_status']; ?>
                                                </button>
                                            <?php
                                        } else {
                                            ?>
                                                <button type="button" class="btn btn-danger btn-sm">
                                                <?php echo $data2['att_status']; ?>
                                                </button>
                                            <?php
                                        }

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
                            $query_lec = "SELECT MAX(lec_no) AS max_lec FROM attendance_record WHERE sub_id = '$sub_id' AND stu_roll_no = '$stu_roll_no'";
                            $result_lec = mysqli_query($connection, $query_lec);
                            if (mysqli_num_rows($result_lec) >= 0) {
                                while ($data2 = mysqli_fetch_assoc($result_lec)) {
                                    $delivered_lec = $data2['max_lec'];

                                    $query_count_att = "SELECT COUNT(*) AS count_att FROM attendance_record WHERE stu_name = '$Student_name' AND att_status = 'present' and sub_id = '$sub_id'";
                                    $result_count_att = mysqli_query($connection, $query_count_att);
                                    $data_count_att = mysqli_fetch_assoc($result_count_att);
                                    $total_present = $data_count_att['count_att'];

                                    echo "$total_present" . "/" . "$delivered_lec";
                                }
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($delivered_lec == 0) {
                                echo "0%";
                            } else {
                                $attendance_percentage = ($total_present / $delivered_lec) * 100;
                                echo $attendance_percentage . "%";
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