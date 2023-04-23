<?php

require '../connection.php';

session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>Teacher Dashboard</title>
    <style>
        #checkBox {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #checkBox>#checkBox1,
        #checkBox2 {
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #356155;
            margin: 0 0.3rem;
            padding: 0.2rem 0.8rem;
        }


        .form-check-input {
            margin: 0 0.3rem;
        }

        .form-check-input:checked {
            background-color: #356155;
            border-color: #356155;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .form-check-input:focus {
            --box-shadow-color: #356155;
            box-shadow: 1px 2px 3px var(--box-shadow-color);
        }
    </style>
</head>

<body>

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

    <?php
    $query = "SELECT * FROM `student_record` WHERE class = 'CSE1'";

    $result = mysqli_query($connection, $query);

    ?>

    <div class="container-fluid mt-3">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#356155;color:white;">
                <h5 class="modal-title">Mark Your Attendance</h5>
                <span>
                <a href="../teacher/teacher-index.php"><button type="button" class="btn"
                        style="background-color:white;color:black;"> <i class='bx bx-home-alt icon'></i>
                        Dashboard</button></a>
                </span>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="form-group row mb-2">
                        <div class="col-sm-4">
                            <label for="lec_no" class="form-label">Total Lecture Delivered</label>
                            <?php
                            $query_lec = "SELECT MAX(lec_no) AS max_lec FROM attendance_record WHERE teach_name = '$t_name'";
                            $result_lec = mysqli_query($connection, $query_lec);
                            if (mysqli_num_rows($result_lec) >= 0) {
                                while ($data2 = mysqli_fetch_assoc($result_lec)) {
                                    $delivered_lec = $data2['max_lec'];
                                    ?>
                                    <input class="form-control" type="text" name="lec_no" id="lec_no"
                                        value="<?php echo $delivered_lec; ?>" readonly>

                                    <?php
                                }
                            }
                            ?>

                        </div>
                        <div class="col-sm-4">
                            <label for="lec_no" class="form-label">Enter Lecture Number</label>
                            <input class="form-control" type="text" name="lec_no" id="lec_no">
                        </div>
                        <div class="col-sm-4">
                            <label for="cont" class="form-label">Today Deliver content</label>
                            <textarea class="form-control" name="cont" id="cont" col="10" row="3"></textarea>
                        </div>
                    </div>
                    <center>
                        <table border='1' cellpadding='10'
                            class="table table-condensed table-bordered table-hover mt-4">
                            <tr align="center">
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

                                    <tr align="center">
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
                                            <span id="checkBox">
                                                <span id='checkBox1'>
                                                    <input class="form-check-input" type="checkbox" name="status[]"
                                                        value="<?php echo $data['roll_no'] . ',' . $data['s_name'] . ',' . $t_name . ',' . $subject_code . ',' . $sub_id . ',' . $sub_name . ',' . "Absent"; ?>">Absent
                                                </span>
                                                <span id='checkBox2'>
                                                    <input class="form-check-input" type="checkbox" name="status[]" checked
                                                        value="<?php echo $data['roll_no'] . ',' . $data['s_name'] . ',' . $t_name . ',' . $subject_code . ',' . $sub_id . ',' . $sub_name . ',' . "Present"; ?>">Present
                                                </span>
                                            </span>

                                        </td>
                                    </tr>

                                    <?php
                                }
                            } else {
                                echo "No Data Found!";
                            }
                            ?>
                        </table><br>
                        <input type="submit" name="s-att-data" id="s-att-data" class="btn"
                            style="background-color:#356155;color:white;padding:0.3rem 2rem 0.3rem 2rem;" value="Next">
                </form><br>

                <?php

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['s-att-data'])) {
                    $lec_no = $_POST['lec_no'];
                    $delivered_cont = $_POST['cont'];
                    //echo "<script>alert('$lec_no', '$delivered_cont');</script>";
                    if (!empty($_POST['status'])) {

                        $alert_displayed = false;

                        foreach ($_POST['status'] as $lec) {
                            list($roll_no, $stu_name, $teach_name, $sub_code, $sub_id, $sub_name, $att_status) = explode(',', $lec);
                            // echo "<script>alert('roll_no: $roll_no, stu_name: $stu_name, teach_name: $teach_name, att_status: $att_status,sub_code: $sub_code,sub_name:$sub_name,sub_id:$sub_id')</script>";
                            $current_date = date("Y-m-d");

                            $sql = "INSERT INTO attendance_record (stu_roll_no,stu_name,teach_name,sub_code,sub_id,sub_name, att_status,att_date,lec_no,delivered_content) VALUES ('$roll_no','$stu_name','$teach_name','$sub_code','$sub_id','$sub_name', '$att_status', '$current_date','$lec_no','$delivered_cont')";
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
            </div>
        </div>
    </div>
    </div>


</body>

</html>