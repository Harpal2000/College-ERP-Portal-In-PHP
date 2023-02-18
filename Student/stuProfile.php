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
    <title>Student Dashboard</title>
</head>

<body>
    <a href="student-index.php"><button type="button">Dashboard</button></a>
    <a href="../stuAtt.php"><button type="button">Daily Attendance</button></a>
    <a href="stuProfile.php"><button type="button">Profile</button></a>
    <center style='margin-top:3rem;'>
        <?php
        $stu_roll_no = $_SESSION['LoginStudent'];
        $query = "select * from student_record where roll_no = $stu_roll_no";

        $result = mysqli_query($connection, $query);
        ?>

        <table border='1' cellpadding='5' width='60%'>
            <tr>
                <th>Personal Information</th>
            </tr>
        </table>



        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
                ?>
                <table width='60%' cellpadding='10'>
                    <tr>
                        <td>Name :
                            <?php echo $data['s_name']; ?><br><br>

                            Father Name :
                            <?php echo $data['father_name']; ?><br><br>

                            Mother Name :
                            <?php echo $data['mother_name']; ?><br><br>

                            Gender :
                            <?php echo $data['s_gender']; ?><br><br>

                            DOB (dd-mm-yy) :
                            <?php echo $data['s_dob']; ?><br><br>

                            Address :
                            <?php echo $data['s_address']; ?>
                        
                        </td>
                        <?php

                        $image = $data['s_image'];
                        $image_src = "../Admin/student_image/" . $image;

                        ?>
                        <td><img src='<?php echo $image_src; ?>' height="190px" width="170px">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>City :
                            <?php echo $data['s_city']; ?>
                        </td>
                        <td>PIN Code :
                            <?php echo $data['s_pincode']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>State :
                            <?php echo $data['s_state']; ?>
                        </td>
                        <td>Country :
                            <?php echo $data['s_country']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Mobile No. :
                            <?php echo $data['s_phone']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Email :
                            <?php echo $data['s_email']; ?>
                        </td>
                    </tr>
                </table>
                <table border='1' cellpadding='5' width='60%'>
                    <tr>
                        <th>Course Information</th>
                    </tr>
                </table>
                <table cellpadding='10' width='60%'>
                    <tr>
                        <td>Batch :
                            <?php echo $data['s_batch']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Roll No. :
                            <?php echo $data['roll_no']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Class :
                            <?php echo $data['class']; ?>
                        </td>
                    </tr>
                </table>
                <?php
            }
        } else {
            echo 'No Data Available';
        }

        ?>
    </center>
</body>

</html>