<?php
require '../connection.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['s-att'])) {
    if (!empty($_POST['radio'])) {
        $select_lec = $_POST['radio'];
        list($class_name, $subject_code) = explode(',', $select_lec);
        // echo "<script>alert('Class Name: $class_name, Subject Code: $subject_code')</script>";
        if ($class_name == 'CSE1') {
            $t_name = $_GET['t_name'];
            header("Location: cse1Att.php?t_name=$t_name&subject_code=$subject_code&class_name=$class_name");
        } else {
            header('Location:cse2Att.php');
        }
    } else {
        echo "Error!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Teacher Dashboard</title>
    <style>
        .form-check-input:checked {
            background-color: #356155;
            border-color: #356155;
        }

        .form-check-input:focus {
            --box-shadow-color: #356155;
            box-shadow: 1px 2px 3px var(--box-shadow-color);
        }
    </style>
</head>

<body>


    <?php if (isset($_GET['t_name'])) {
        $t_name = $_GET['t_name'];
    } ?>

    <div class="container-fluid mt-3">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#356155;color:white;">
                <h5 class="modal-title">Your Today Lecture's</h5>
                <span>
                    <a href="../teacher/teacher-index.php"><button type="button" class="btn"
                            style="background-color:white;color:black;">My Dashboard</button></a>
                </span>
            </div>
            <div class="modal-body">
                <center>
                    <?php
                    $query = "SELECT * FROM `timetable` WHERE lec_day = 'monday' and faculty_name = '$t_name'";
                    $result = mysqli_query($connection, $query);
                    ?>

                    <form method="POST" action="">
                        <table border='1' cellpadding='10'
                            class="table table-condensed table-bordered table-hover mt-4">
                            <tr align="center">
                                <td>Sr No.</td>
                                <td>Subject Code</td>
                                <td>Subject Name</td>
                                <td>Time Slot</td>
                                <td>Day</td>
                                <td>Room No.</td>
                                <td>Subject Type</td>
                                <td>Class</td>
                                <td>Select Lecture</td>
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
                                            <?php echo $data['subject_code']; ?>
                                            <input type="hidden" name="subject_code"
                                                value="<?php echo $data['subject_code']; ?>">
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
                                        <td><input class="form-check-input" type="radio" name="radio"
                                                value="<?php echo $data['class'] . ',' . $data['subject_code']; ?>">
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "No Data Found!";
                            }
                            ?>
                        </table><br><br>
                        <input type="submit" class="btn"
                            style="background-color:#356155;color:white;padding:0.3rem 2rem 0.3rem 2rem;" name="s-att"
                            id="s-att" value="Next">
                    </form>
                </center>
            </div>
        </div>
    </div>
    </div>



</body>

</html>