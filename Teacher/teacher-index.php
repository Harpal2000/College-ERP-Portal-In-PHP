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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Teacher Dashboard</title>
</head>

<body>

    <h2>Welcome Back :)
        <?php echo $_SESSION['LoginTeacher']; ?>
    </h2>

    <center>
        <?php
        $teacher_name = $_SESSION['LoginTeacher'];
        $query = "SELECT * FROM `timetable` WHERE faculty_name = '$teacher_name'";

        $result = mysqli_query($connection, $query);

        ?>
        <div class="container-fluid mt-3">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#356155;color:white;">
                    <h5 class="modal-title">Your Time Table</h5>
                    <span>
                        <a href="../login.php"><button type="button" class="btn"
                                style="background-color:white;color:black;">LogOut</button></a>

                        <a href="student_att.php?t_name=<?php echo $_SESSION['LoginTeacher']; ?>"><button type="button"
                                class="btn" style="background-color:white;color:black;">Daily
                                Attendance</button></a>
                        <a href="upload_assignments.php?t_name=<?php echo $_SESSION['LoginTeacher']; ?>"><button
                                type="button" class="btn" style="background-color:white;color:black;">Upload
                                Assignments</button></a>
                        <a href="stu_internal_mark.php?t_name=<?php echo $_SESSION['LoginTeacher']; ?>"><button
                                type="button" class="btn" style="background-color:white;color:black;">Upload Internal
                                Marks</button></a>
                    </span>
                </div>
                <div class="modal-body">
                    <table border='1' cellpadding='10' class="table table-condensed table-bordered table-hover mt-4">
                        <tr>
                            <th>Sr No.</th>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Time Slot</th>
                            <th>Day</th>
                            <th>Room No.</th>
                            <th>Subject Type</th>
                            <th>Class</th>
                        </tr>

                        <?php
                        $sr_no = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr>
                                    <th>
                                        <?php echo $sr_no; ?>
                                    </th>
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
                </div>
            </div>
        </div>
        </div>


    </center>
</body>

</html>