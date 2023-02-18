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
    <a href="index.php"><button type="button">Main Page</button></a>
    <a href="teachDash.php"><button type="button">My Dashboard</button></a>
    <a href="stuAtt.php"><button type="button">Daily Attendance</button></a>


    <center>
        <h1>Your Today's Lecture</h1>
        <?php
        
        $query = "SELECT * FROM `timetable` WHERE day = 'Tuesday'";

        $result = mysqli_query($connection, $query);

        ?>

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
                        </td>
                        <td>
                            <?php echo $data['subject_name']; ?>
                        </td>
                        <td>
                            <?php echo $data['time_slot']; ?>
                        </td>
                        <td>
                            <?php echo $data['day']; ?>
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
                        <td>
                            <form method="POST" action="">
                                <input type="radio" name="radio" value="<?php echo $data['class']; ?>">

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

        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['s-att'])) {

            if (!empty($_POST['radio'])) {

                $select_lec = $_POST['radio'];
                if( $select_lec == 'CSE1'){
                    header('Location:cse1Att.php');
                }else{
                    header('Location:cse2Att.php');
                }

            } else {
                echo "Error!";
            }

        } 



        ?>
    </center>
</body>

</html>