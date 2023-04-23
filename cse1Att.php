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
        <?php if (isset($_GET['class_name'])) {
            $class_name = $_GET['class_name'];
        }
        ?>
        <?php if (isset($_GET['subject_code'])) {
            $subject_code = $_GET['subject_code'];
        }
        ?>
        <?php if (isset($_GET['t_name'])) {
            $t_name = $_GET['t_name'];
            $teach_record = "SELECT * FROM `teacher_record` WHERE t_name = '$t_name'";

            $teach_result = mysqli_query($connection, $teach_record);
            if (mysqli_num_rows($teach_result) > 0) {
                while ($data = mysqli_fetch_assoc($teach_result)) {
                    $teacher_id = $data['t_id'];
                }
            }

            $teach_record = "SELECT * FROM `timetable` WHERE subject_code = '$subject_code' and faculty_name = '$t_name' and class= '$class_name' and lec_day = 'monday' ";

            $teach_result = mysqli_query($connection, $teach_record);
            if (mysqli_num_rows($teach_result) > 0) {
                while ($data = mysqli_fetch_assoc($teach_result)) {
                    $sub_id = $data['id'];
                    $sub_name = $data['subject_name'];
                }
            }

        } ?>
        <h1>Your Today's Attendance
            <?php echo $sub_id . "<br>" . $subject_code; ?>
        </h1>
        <?php
        $query = "SELECT * FROM `student_record` WHERE class = 'CSE1'";

        $result = mysqli_query($connection, $query);

        ?>

        <table border='1' cellpadding='10'>
            <tr>
                <th>Sr No.</th>
                <th>Student Name</th>
                <th>Student Roll No</th>
                <th>Absent/Present</th>
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
                            <?php echo $data['roll_no']; ?>
                        </td>
                        <td>
                            <form method="POST" action="">
                                <input type="checkbox" name="status[]"
                                    value="<?php echo $data['roll_no'] . ',' . $data['s_name'] . ',' . $t_name . ',' . $subject_code . ',' . $sub_id . ',' . $sub_name . ',' . "Absent"; ?>">A

                                <input type="checkbox" name="status[]"
                                    value="<?php echo $data['roll_no'] . ',' . $data['s_name'] . ',' . $t_name . ',' . $subject_code . ',' . $sub_id . ',' . $sub_name . ',' . "Present"; ?>">P

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
        </form><br>

        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['s-att-data'])) {

            if (!empty($_POST['status'])) {

                $alert_displayed = false;

                foreach ($_POST['status'] as $lec) {
                    list($roll_no, $stu_name, $teach_name, $sub_code, $sub_id, $sub_name, $att_status) = explode(',', $lec);
                    // echo "<script>alert('roll_no: $roll_no, stu_name: $stu_name, teach_name: $teach_name, att_status: $att_status,sub_code: $sub_code,sub_name:$sub_name,sub_id:$sub_id')</script>";
                    $current_date = date("Y-m-d");

                    $sql = "INSERT INTO attendance_record (stu_roll_no,stu_name,teach_name,sub_code,sub_id,sub_name, att_status,att_date) VALUES ('$roll_no','$stu_name','$teach_name','$sub_code','$sub_id','$sub_name', '$att_status', '$current_date')";
                    $result = mysqli_query($connection, $sql);

                    if (!$result) {
                        echo "Error: " . mysqli_error($connection);
                    } else {
                        $alert_displayed = true;
                    }
                }

                if ($alert_displayed) {
                    echo "<script>alert('Attendance Record Added Successfully');</script>";
                }

            } else {
                echo "Error!";
            }

        }

        ?>
    </center>
</body>

</html>