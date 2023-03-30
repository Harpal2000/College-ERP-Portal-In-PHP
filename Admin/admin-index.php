<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginAdmin'])) {
    header('Location:../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body style="background: #80808045;">
    <br><br>
    <div class="container-fluid">
        <a href="../login.php"><button type="button" class="btn btn-secondary btn-sm">Login Dashboard</button></a>
        <a href="student_records.php"><button type="button" class="btn btn-secondary btn-sm">Student
                Records</button></a>
        <a href="teacher_record.php"><button type="button" class="btn btn-secondary btn-sm">Teacher Records</button></a>
        <a href="courses.php"><button type="button" class="btn btn-secondary btn-sm">Add Courses</button></a>
        <a href="Upload_fee.php"><button type="button" class="btn btn-secondary btn-sm">Assign Fee</button></a>
        <a href="subject_record.php"><button type="button" class="btn btn-secondary btn-sm">Subject Details</button></a>
        <a href="timetable_record.php"><button type="button" class="btn btn-secondary btn-sm">TimeTable</button></a>

    </div>
    <div class="container-fluid">
        <div class="row mt-3 ml-3 mr-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo "Welcome back " . $_SESSION['LoginAdmin'] . "!" ?>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>