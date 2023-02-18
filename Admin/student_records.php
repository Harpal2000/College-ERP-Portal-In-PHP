<?php

require '../connection.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>All Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
</head>

<body>
    <br>
    <div class="container-fluid">
        <a href="admin-index.php"><button type="button" class="btn btn-secondary btn-sm">Main Dashboard</button></a>
        <a href="student_register.php"><button type="button" class="btn btn-secondary btn-sm">Student
                Register</button></a>
    </div>
    <div id="records">
        <center>
            <div id="tableDiv" style="width:80%">
                <h1>Student's Records</h1>
                <hr>
                <br>
                <?php
                $query = "SELECT * FROM student_record";

                $result = mysqli_query($connection, $query);

                ?>


                <?php
                $query2 = "select * from login where role='Student' or role='teacher'";

                $result2 = mysqli_query($connection, $query2);

                if ($result2 && mysqli_num_rows($result2) > 0) {
                    while ($data2 = mysqli_fetch_assoc($result2)) {
                        $Student_status = $data2['account'];
                        $Student_username = $data2['username'];
                    }
                } else {
                    echo 'No Data Available';
                }

                ?>

                <table id="myTable" class="display table-condensed table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id_No</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Information</th>
                            <th>Contact No.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr align='center'>
                                    <td>
                                        <?php echo $data['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['s_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['s_pass']; ?>
                                    </td>
                                    <td>
                                        <small><b>Email: </b><i>
                                                <?php echo $data['s_email']; ?>
                                            </i></small><br>
                                        <small><b>Class: </b><i>
                                                <?php echo $data['class']; ?>
                                            </i> </small>
                                        <small><b>Roll no: </b><i>
                                                <?php echo $data['roll_no']; ?>
                                            </i></small>
                                    </td>
                                    <td>
                                        <?php echo $data['s_phone']; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-danger delete_student"
                                            type="button">Delete</button>
                                    </td>
                                </tr>


                                <?php
                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {

                                    if (!empty($_POST['status'])) {
                                        $s_username = $data['roll_no'];
                                        echo "<script>alert('$s_username')</script>";
                                        $account = 'Activate';
                                        $s_password = $_POST['s_pass'];
                                        $id = $_POST['Id'];
                                        $role = 'Student';

                                        $Query = "UPDATE `student_record` SET acc_status = 'Activate' WHERE roll_no = '$s_username';";
                                        $Query .= "INSERT INTO `login` (`Id`,`username`,`password`,`role`,`account`) VALUES ('$id','$s_username','$s_password','$role','$account');";
                                        //echo $Query; // to check for syntax error
                                        if (mysqli_multi_query($connection, $Query)) {
                                            echo "<script>alert('Register Successfully');window.location = 'records.php';</script>";

                                        } else {
                                            echo "Error in Query: " . $Query . "<br>" . mysqli_error($connection);
                                        }
                                    } else {
                                        echo "Error!";
                                    }
                                }
                                ?>
                                <?php
                            }
                        }

                        ?>
                    </tbody>
                </table>
                <br>
        </center>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "pageLength": 5
            });
        });

    </script>


</body>

</html>