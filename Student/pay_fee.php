<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginStudent'])) {
    header('Location:login.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>All Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <br>
    <a href="student-index.php"><button type="button" class="btn btn-secondary btn-sm">Main Dashboard</button></a>
    <div id="records">
        <center>
            <br><br><br>
            <div id="tableDiv" style="width:80%">
                <h1>Student's Fee Records</h1><br><br><br>
                <?php
                $stu_roll_no = $_SESSION['LoginStudent'];
                $query = "select * from student_record where roll_no = $stu_roll_no";

                $result = mysqli_query($connection, $query);
                ?>

                <?php
                $query_course = "select * from student_record where roll_no = $stu_roll_no";
                // echo "<script>alert('$query_course')</script>";

                $result_c = mysqli_query($connection, $query_course);
                if (mysqli_num_rows($result_c) > 0) {
                    while ($data = mysqli_fetch_assoc($result_c)) {
                        $course_id = $data['s_course'];
                        // echo "<script>alert('$course_id')</script>";
                    }
                }
                ?>


                <?php
                $query2 = "select * from courses where id = $course_id";

                $result2 = mysqli_query($connection, $query2);

                if ($result2 && mysqli_num_rows($result2) > 0) {
                    while ($data2 = mysqli_fetch_assoc($result2)) {
                        $course_desc = $data2['description'];
                        $course_name = $data2['course'];
                        $course_dur = $data2['level'];
                        $course_amount = $data2['total_amount'];
                    }
                } else {
                    echo 'No Data Available';
                }

                ?>

                <table id="myTable" class="display table-condensed table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr align="center">
                            <th>Student Name</th>
                            <th>Father Name</th>
                            <th>Roll No</th>
                            <th>Information</th>
                            <th>Current Semester</th>
                            <th>Current Semester Total fee</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr align='center'>
                                    <td>
                                        <?php echo $data['s_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['father_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['roll_no']; ?>
                                    </td>
                                    <td>
                                        <small><b>Course: </b><i>
                                                <?php echo $course_desc . " " . "( " ."$course_name". " )"; ?>
                                            </i></small><br>
                                        <small><b>Course Duration: </b><i>
                                                <?php echo $course_dur; ?>
                                            </i></small><br>

                                    </td>
                                    <td>
                                        <?php echo $data['s_sem']; ?>
                                    </td>
                                    <td>
                                        <?php echo $course_amount; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }else{
                            echo "NO data found";
                        }
                        ?>
                    </tbody>
                </table>
                <div>
        </center>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>

</html>