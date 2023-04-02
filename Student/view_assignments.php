<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginStudent'])) {
    header('Location:login.php');
}

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


$query2 = "SELECT * FROM timetable WHERE lec_day = 'monday' AND class = '$Student_class' AND class_group = '$Student_group' OR (lec_sch = 'combine' AND lec_day = 'monday' AND class = '$Student_class')";


$result2 = mysqli_query($connection, $query2);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard: View Assignments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        #assignTab table {
            width: 80%;
        }
    </style>
</head>

<body>
    <center>
        <h3 class="display-4">Your Assignments</h3>
        <div id="assignTab">
            <table id="SelectClassTable" class="table table-striped mt-1">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Subject Name/Code</th>
                        <th>Assignment-1</th>
                        <th>Assignment-2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    if (mysqli_num_rows($result2) > 0) {
                        while ($data2 = mysqli_fetch_assoc($result2)) {
                            $subject_name = $data2['subject_name']; ?>
                            <tr>
                                <td>
                                    <?php echo $i++ ?>
                                </td>
                                <td>
                                    <?php echo $data2['subject_name'] . ' [ ' . $data2['subject_code'] . ']' ?>
                                </td>

                                <?php
                                $Query = "select * from assignment_record where class = '$Student_class' and subject_name = '$subject_name'";
                                $assign_result = mysqli_query($connection, $Query);
                                if (mysqli_num_rows($assign_result) > 0) {
                                    while ($data = mysqli_fetch_assoc($assign_result)) { ?>
                                        <td>
                                            <?php if ($data['assign_no'] == '1') { ?>
                                                <a href="../Teacher/assignment_data/<?php echo $data['assign_file'] ?>">Assignment-1
                                            </td>
                                            <td>
                                            <?php } else if ($data['assign_no'] == '2') { ?>
                                                    <a href="../Teacher/assignment_data/<?php echo $data['assign_file'] ?>">Assignment-2
                                                </td>
                                            </tr>
                                    <?php } else {
                                                echo "No records found.";
                                            } ?>
                                <?php }
                                } ?>




                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </center>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>