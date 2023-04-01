<?php

require '../connection.php';

session_start();

if (isset($_GET['t_name'])) {
    $teacherName = $_GET['t_name'];
    echo 'Teacher Name: ' . $teacherName;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload Internal Assessment Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        #SelectClassTable {
            width: 90%;
        }

        #left-side-cont {
            padding: 2rem;
        }

        #right-side-cont {
            padding: 2rem;
        }
    </style>
</head>

<body>

    <?php
    $Query = "SELECT DISTINCT class FROM timetable WHERE faculty_name = '$teacherName'";
    $QueryResult = mysqli_query($connection, $Query);
    ?>

    <div class="container-fluid">
        <center>
            <h1 class="display-4">Upload Your Assignment And Internal Marks</h1>
            <hr color="black">
        </center>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div id="left-side-cont">
                    <form method="post" action="">
                        <table border='1' id="SelectClassTable" cellpadding='6'
                            class="table table-condensed table-bordered table-hover mt-4">
                            <thead>
                                <tr align="center">
                                    <th align="center">
                                        Select Class For Upload Marks
                                    </th>
                                    <td>
                                        <select class="form-select form-select-lg" aria-label=".form-select-lg example"
                                            name="select">
                                            <option selected disabled>--------- Select Your Class ----------</option>
                                            <?php
                                            if (mysqli_num_rows($QueryResult) > 0) {
                                                while ($data = mysqli_fetch_assoc($QueryResult)) {
                                                    ?>
                                                    <option value="<?php echo $data['class']; ?>">
                                                        <?php echo $data['class']; ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <th>
                                        Select Subject Name
                                    </th>
                                    <td>
                                        <select class="form-select form-select-lg" aria-label=".form-select-lg example"
                                            name="select2">
                                            <option selected disabled>--------- Select Your Subject ----------</option>
                                            <?php
                                            $Query = "SELECT DISTINCT subject_name FROM timetable WHERE faculty_name = '$teacherName'";
                                            $QueryResult = mysqli_query($connection, $Query);
                                            if (mysqli_num_rows($QueryResult) > 0) {
                                                while ($data = mysqli_fetch_assoc($QueryResult)) {
                                                    ?>
                                                    <option value="<?php echo $data['subject_name']; ?>">
                                                        <?php echo $data['subject_name']; ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <th>
                                        Upload Assignment Marks or MST-Marks
                                    </th>
                                    <td>
                                        <select class="form-select form-select-lg" aria-label=".form-select-lg example"
                                            name="select3">
                                            <option selected disabled>--------- Select Assignment/MST ----------
                                            </option>
                                            <option value="Assignment Marks">Assignment Marks</option>
                                            <option value="MST Marks">MST Marks</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <th>
                                        Enter Assignment/MST No. Here
                                    </th>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="assMst">
                                        </div>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td colspan="2">
                                        <input type="submit" id="class_btn" name="class_btn"
                                            class="btn btn-primary btn-sm" value="submit">
                                    </td>
                                </tr>
                                <thead>
                        </table>
                    </form>
                </div>
            </div>
            <div class="col-md-6">

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['class_btn'])) {
                    $selected_sub = $_POST['select2'];
                    $selected_assMst = $_POST['select3'];
                    $selected_assMstNo = $_POST['assMst'];
                    //echo "$selected_assMst";
                    if (!empty($_POST['select'])) {
                        $selected_class = $_POST['select'];
                        // echo "$selected_class";
                        $sql = "SELECT * FROM student_record WHERE class = '$selected_class'";
                        $result = mysqli_query($connection, $sql);
                        ?>
                        <div id="left-side-cont">
                            <form method="POST">
                                <table class="table table-condensed table-bordered table-hover mt-4" id="SelectClassTable">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Roll No</th>
                                        <th>Enter Marks</th>
                                    </tr>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>

                                        <tr>
                                            <td>
                                                <?php echo $row['id'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['s_name'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['class'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['roll_no'] ?>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="name[]" value="<?php echo $row['s_name'] ?>">
                                                    <input type="hidden" name="roll_no[]" value="<?php echo $row['roll_no'] ?>">
                                                    <input type="hidden" name="subject" value="<?php echo $selected_sub ?>">
                                                    <input type="hidden" name="assMst" value="<?php echo $selected_assMst ?>">
                                                    <input type="hidden" name="assMstNo" value="<?php echo $selected_assMstNo ?>">
                                                    <input type="hidden" name="class" value="<?php echo $selected_class ?>">
                                                    <input type="hidden" name="student_id[]" value="<?php echo $row['id'] ?>">
                                                    <input type="text" class="form-control" name="marks[]" value="">
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                    }
                    ?>
                                <tr align="center">
                                    <td colspan="5">
                                        <input type="submit" name="marks_btn" class="btn btn-primary btn-sm"
                                            value="Upload Marks">

                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['marks_btn'])) {
        $marks = $_POST['marks'];
        $student_ids = $_POST['student_id'];
        $names = $_POST['name'];
        $rollNos = $_POST['roll_no'];
        $selected_sub = $_POST['subject'];
        $selected_class = $_POST['class'];
        $selected_assMst = $_POST['assMst'];
        $selected_assMstNo = $_POST['assMstNo'];

        for ($i = 0; $i < count($marks); $i++) {
            $id = $student_ids[$i];
            $mark = $marks[$i];
            $name = $names[$i];
            $rollNo = $rollNos[$i];
            // echo "Mark for student with ID $id: $name: $mark:$rollNo <br>";
            $sql = "INSERT INTO internal_marks (`stu_id`, `stu_name`, `stu_rollNo`, `stu_class`,`subject`,`ass_or_mst`,`assMstNo`,`stu_marks`) VALUES ('$id', '$name', '$rollNo', '$selected_class', '$selected_sub','$selected_assMst', '$selected_assMstNo','$mark')";
            mysqli_query($connection, $sql);
        }
        echo "<script>alert('Marks uploaded successfully');</script>";
    }
    ?>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>

</html>