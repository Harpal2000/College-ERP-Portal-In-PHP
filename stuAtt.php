<?php
require 'connection.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['s-att'])) {
    if (!empty($_POST['radio'])) {
        $select_lec = $_POST['radio'];
        // $subject_code = $_POST['subject_code'];
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
    <title>Teacher Dashboard</title>
</head>

<body>
    <a href="index.php"><button type="button">Main Page</button></a>
    <a href="teachDash.php"><button type="button">My Dashboard</button></a>
    <a href="stuAtt.php"><button type="button">Daily Attendance</button></a>

    <?php if (isset($_GET['t_name'])) {
        $t_name = $_GET['t_name'];
    } ?>

    <center>
        <h1>Your Today's Lecture</h1>
        <?php
        $query = "SELECT * FROM `timetable` WHERE lec_day = 'monday' and faculty_name = '$t_name'";
        $result = mysqli_query($connection, $query);
        ?>

        <form method="POST" action="">
            <table border='1' cellpadding='10'>
                <tr>
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
                        <tr>
                            <td>
                                <?php echo $sr_no; ?>
                            </td>
                            <?php $sr_no = $sr_no + 1 ?>
                            <td>
                                <?php echo $data['subject_code']; ?>
                                <input type="hidden" name="subject_code" value="<?php echo $data['subject_code']; ?>">
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
                            <td><input type="radio" name="radio"
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
            <input type="submit" name="s-att" id="s-att" value="Next">
        </form>
    </center>

</body>

</html>