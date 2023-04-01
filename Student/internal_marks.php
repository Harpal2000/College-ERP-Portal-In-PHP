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
    <title>Dashboard: Internal Marks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        .container-fluid {
            max-width: 70vw;
            height: 20rem;
            /* background-color: #6c757d2b; */
            background-color: #dad7cd;
            margin-top: 5rem;
            padding: 0;
            border-radius: 0.5rem;
        }

        .heading {
            /* background-color: #1e7e347d; */
            background-color: #588157;
            max-width: 70vw;
            height: 8vh;
            text-align: center;
            color: white;
        }

        #rollNo {
            background-color: #344e41;
            max-width: 8.3rem;
            height: 1.5rem;
            text-align: center;
            border-radius: 2rem;
        }

        p {
            margin: 2px;
        }

        #MarksTable {
            font-size: 0.7rem;
        }
    </style>
</head>

<body>
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

    <div class="container-fluid">
        <div class="heading">
            <p>Internal Assessment Record</p>
            <center>
                <p id="rollNo">Roll No.2000105</p>
            </center>
        </div>
        <div id="MarksTable">
            <table id="SelectClassTable" class="table table-striped mt-1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject Name/code</th>
                        <th></th>
                        <th></th>
                        <th>A1</th>
                        <th>A2</th>
                        <th>MST-1</th>
                        <th>MST-2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (mysqli_num_rows($result2) > 0) {
                        while ($data2 = mysqli_fetch_assoc($result2)) {
                            $subject_name = $data2['subject_name'];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $i++ ?>
                                </td>
                                <td>
                                    <?php echo $data2['subject_name'] . ' [ ' . $data2['subject_code'] . ']' ?>
                                </td>
                                <td></td>
                                <td></td>
                                <?php
                                $Query = "SELECT * FROM internal_marks WHERE stu_rollNo = $stu_roll_no AND subject_name = '$subject_name'";
                                $result = mysqli_query($connection, $Query);
                                $marks = array("Assignment-1" => "N/A", "Assignment-2" => "N/A", "MST-1" => "N/A", "MST-2" => "N/A");
                                ?>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        switch ($data['assMstNo']) {
                                            case 'Assignment-1':
                                                $marks['Assignment-1'] = $data['stu_Marks'];
                                                break;
                                            case 'Assignment-2':
                                                $marks['Assignment-2'] = $data['stu_Marks'];
                                                break;
                                            case 'MST-1':
                                                $marks['MST-1'] = $data['stu_Marks'];
                                                break;
                                            case 'MST-2':
                                                $marks['MST-2'] = $data['stu_Marks'];
                                                break;
                                        }
                                    }
                                }
                                ?>
                                <td>
                                    <?php echo $marks['Assignment-1']; ?>
                                </td>
                                <td>
                                    <?php echo $marks['Assignment-2']; ?>
                                </td>
                                <td>
                                    <?php echo $marks['MST-1']; ?>
                                </td>
                                <td>
                                    <?php echo $marks['MST-2']; ?>
                                </td>
                                <?php
                        }
                        ?>
                        </tr>
                        <?php

                    } else {
                        echo 'No Data Available';
                    }
                    ?>
                </tbody>
            </table>
        </div>
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