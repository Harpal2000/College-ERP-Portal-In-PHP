<?php

require '../connection.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Student Register</title>
    <style>
        label {
            font-weight: bold;
        }

        .form-control {
            line-height: 2;
            border: 1px solid #ddd;
            border-radius: 2px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #356155;
        }

        .form-check-input:checked {
            background-color: #356155;
            border-color: #356155;
        }

        .form-check-input:focus {
            box-shadow: none;
        }

        .form-control:hover {
            border-color: #356155;
        }
    </style>
</head>

<body>


    <div class="container-fluid mt-3">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#356155;color:white;">
                <h5 class="modal-title">Student Registration</h5>
                <span class="float-end">
                    <a href="admin-index.php"><button type="button" class="btn"
                            style="background-color:white;color:black;">Main Dashboard</button></a></a>
                </span>
            </div>
            <div class=" modal-body pb-0">
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group row mb-4">
                        <div class="col-sm-4">
                            <label for="s_id" class="form-label">Enter Student Id</label>
                            <input class="form-control" type="text" name="s_id" id="s_id"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-4">
                            <label for="usernmae" class="form-label">Enter Student Name</label>
                            <input class="form-control" type="text" name="username" id="username"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-4">
                            <label for="roll_no" class="form-label">Enter Student Roll-No</label>
                            <input class="form-control" type="text" name="roll_no" id="roll_no"
                                aria-label="default input example">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <div class="col-sm-4">
                            <label for="img" class="form-label">Upload Student Image</label>
                            <input class="form-control" type="file" name="img" id="img"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-4">
                            <label for="father_name" class="form-label">Enter Father Name</label>
                            <input class="form-control" type="text" name="father_name" id="father_name"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-4">
                            <label for="mother_name" class="form-label">Enter Mother Name</label>
                            <input class="form-control" type="text" name="mother_name" id="mother_name"
                                aria-label="default input example">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <div class="col-sm-2">
                            <label for="img" class="form-label mb-3">Enter Student Gender:</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value='Male'>
                                <label class="form-check-label" for="gender">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value='Female'>
                                <label class="form-check-label" for="gender">Female</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="dob" class="form-label">Enter Student D.O.B</label>
                            <input class="form-control" type="text" name="dob" id="dob"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-2">
                            <label for="password" class="form-label">Student Dashboard Password</label>
                            <input class="form-control" type="text" id="password" name="password"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-3">
                            <label for="course_id" class="form-label">Select Student Course</label>
                            <select class="form-select" id="course_id" name="course_id">
                                <option value=""></option>
                                <?php
                                $student = $connection->query("SELECT *,concat(course,'-',level) as class FROM courses order by course asc ");
                                while ($row = $student->fetch_assoc()):
                                    ?>
                                    <option value="<?php echo $row['id'] ?>"
                                        data-amount="<?php echo $row['total_amount'] ?>">
                                        <?php echo $row['class'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="total_fee" class="form-label">Student Annual Course Fee</label>
                            <input type="text" class="form-control" id="total_fee" name="total_fee"
                                value="<?php echo isset($total_fee) ? number_format($total_fee) : '' ?>" required
                                readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <div class="col-sm-4">
                            <label for="email" class="form-label">Enter E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-sm-4">
                            <label for="phone" class="form-label">Enter Mobile-no:</label>
                            <input type="text" class="form-control" id="phone" name="phone" maxlength="10">
                        </div>
                        <div class="col-sm-2">
                            <label for="class" class="form-label">Enter Class:</label>
                            <input type="text" class="form-control" id="class" name="class">
                        </div>
                        <div class="col-sm-2">
                            <label for="batch" class="form-label">Enter Student Batch:</label>
                            <input type="text" class="form-control" id="batch" name="batch">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <div class="col-sm-4">
                            <label for="address" class="form-label">Enter Student Address:</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="col-sm-2">
                            <label for="city" class="form-label">Enter Student City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="col-sm-2">
                            <label for="pin" class="form-label">Enter Pin Code</label>
                            <input type="text" class="form-control" id="pin" name="pin">
                        </div>
                        <div class="col-sm-2">
                            <label for="state" class="form-label">Enter Student State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>
                        <div class="col-sm-2">
                            <label for="country" class="form-label">Enter Student Country</label>
                            <input type="text" class="form-control" id="country" name="country">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn" name="r-btn" id="r-btn"
                            style="background-color:#356155;color:white;width:20%;" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

    <script>
        $('#course_id').change(function () {
            var amount = $('#course_id option[value="' + $(this).val() + '"]').attr('data-amount')
            $('[name="total_fee"]').val(parseFloat(amount).toLocaleString('en-US', { style: 'decimal', maximumFractionDigits: 2, minimumFractionDigits: 2 }))
        })
    </script>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['r-btn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $class = $_POST['class'];
        $roll_no = $_POST['roll_no'];
        $s_id = $_POST['s_id'];
        $father_name = $_POST['father_name'];
        $mother_name = $_POST['mother_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $batch = $_POST['batch'];
        $course_id = $_POST['course_id'];
        $total_fee = $_POST['total_fee'];

        echo "<script>alert($gender);</script>";

        if ($roll_no >= 2000046 & $roll_no <= 2000091) {
            $class_gp = 'G1';
        } else if ($roll_no >= 2000092 & $roll_no <= 2000137) {
            $class_gp = 'G2';
        } else if ($roll_no >= 2000138 & $roll_no <= 2000185) {
            $class_gp = 'G1';
        } else if ($roll_no >= 2000186 & $roll_no <= 2000235) {
            $class_gp = 'G2';
        } else {
            $class_gp = 'Undefined';
        }


        $acc_status = 'Activate';
        $s_role = 'Student';
        $sem = '1';


        $filename = $_FILES['img']['name'];



        $target_dir = "student_image/";

        $target_file = $target_dir . basename($_FILES["img"]["name"]);

        // Select file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


        // valid file extensions
        $extensions_arr = array("jpg", "jpeg", "png", "gif");

        // Check extension
        if (in_array($imageFileType, $extensions_arr)) {

            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_dir . $filename)) {
                //$Query = "INSERT INTO `student_record` (`s_image`) VALUES  ('$filename')";
                $Query = "INSERT INTO `student_record` (`Id`, `s_name`, `father_name`, `mother_name`, `s_gender`, `s_dob`, `s_address`, `s_city`, `s_pincode`, `s_state`, `s_country`, `s_email`, `s_pass`, `s_phone`, `class`, `roll_no`,`s_sem`,`s_course`,`s_group`,`course_amount`, `s_batch`,`s_image`) VALUES  ('$s_id','$username','$father_name','$mother_name','$gender','$dob','$address','$city','$pin','$state','$country','$email','$password','$phone','$class','$roll_no','$sem','$course_id ','$class_gp','$total_fee','$batch','$filename');";

                echo "<script>alert($Query);</script>";

                $Query .= "INSERT INTO `login` (`id`, `username`, `password`, `role`, `account`) VALUES ('$s_id','$roll_no','$password','$s_role','$acc_status');";

                if ($connection->multi_query($Query) === TRUE) {
                    echo "<script>alert('Register Successfully');window.location = 'student_register.php';</script>";

                } else {
                    echo "Error: " . $Query . "<br>" . mysqli_error($Connection);
                }
            }
        } else {
            echo 'Error in uploading file - ' . $_FILES['img']['name'] . '';
        }

        //
    
    }

    ?>

</body>

</html>