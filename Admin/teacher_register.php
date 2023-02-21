<?php

require '../connection.php';

?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Teacher Register</title>
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
    <div class="container-fluid mt-5">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#356155;color:white;">
                <h5 class="modal-title">Teacher Registration</h5>
                <span class="float-end">
                    <a href="admin-index.php"><button type="button" class="btn"
                            style="background-color:white;color:black;">Main Dashboard</button></a></a>
                </span>
            </div>
            <div class=" modal-body pb-0">
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group row mb-4">
                        <div class="col-sm-4">
                            <label for="s_id" class="form-label">Teacher Id</label>
                            <input class="form-control" type="text" name="t_id" id="t_id"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-4">
                            <label for="t_username" class="form-label">Enter Teacher Name</label>
                            <input class="form-control" type="text" name="t_username" id="t_username"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-4">
                            <label for="t_password" class="form-label">Enter Teacher Password</label>
                            <input class="form-control" type="text" name="t_password" id="t_password"
                                aria-label="default input example">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <div class="col-sm-4">
                            <label for="t_phone" class="form-label">Enter Teacher Mobile-No</label>
                            <input class="form-control" type="text" name="t_phone" id="t_phone" maxlength="10"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-4">
                            <label for="t_stream" class="form-label">Enter Teacher Stream</label>
                            <input class="form-control" type="text" name="t_stream" id="t_stream"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-4">
                            <label for="t_email" class="form-label">Enter Teacher E-Mail</label>
                            <input class="form-control" type="text" name="t_email" id="t_email"
                                aria-label="default input example">
                        </div>

                    </div>

                    <div class="form-group row mb-4">
                        <div class="col-sm-4">
                            <label for="gender" class="form-label mb-4">Enter Teacher Gender:</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value='Male'>
                                <label class="form-check-label" for="gender">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value='Female'>
                                <label class="form-check-label" for="gender">Female</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="t_dob" class="form-label">Enter Teacher D.O.B</label>
                            <input class="form-control" type="text" name="t_dob" id="t_dob"
                                aria-label="default input example">
                        </div>
                        <div class="col-sm-4">
                            <label for="t_addr" class="form-label">Enter Teacher Address</label>
                            <input class="form-control" type="text" name="t_addr" id="t_addr"
                                aria-label="default input example">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="submit" class="btn" name="t-btn" id="t-btn"
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

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['t-btn'])) {
        $t_username = $_POST['t_username'];
        $t_password = $_POST['t_password'];
        $t_email = $_POST['t_email'];
        $t_phone = $_POST['t_phone'];
        $t_stream = $_POST['t_stream'];
        $t_id = $_POST['t_id'];
        $t_dob = $_POST['t_dob'];
        $t_addr = $_POST['t_addr'];
        $gender = $_POST['gender'];

        $t_role = 'Teacher';
        $acc_status = 'Activate';

        $current_date = date("Y-m-d");



        $Query = "INSERT INTO `teacher_record` (`t_id`,`t_name`, `t_email`, `t_pass`, `t_phone`,`t_gender`, `t_stream`,`hire_date`,`t_dob`,`t_address`) VALUES ('$t_id','$t_username','$t_email','$t_password','$t_phone','$gender','$t_stream','$current_date','$t_dob','$t_addr');";
        $Query .= "INSERT INTO `login` (`id`, `username`, `password`, `role`, `account`) VALUES ('$t_id','$t_username','$t_password','$t_role','$acc_status');";

        if ($connection->multi_query($Query) === TRUE) {
            echo "<script>
        alert('Register Successfully');
        window.location = 'teacher_register.php';
        </script>";

        } else {
            echo "Error: " . $Query . "<br>" . mysqli_error($Connection);
        }
    }

    ?>
</body>

</html>