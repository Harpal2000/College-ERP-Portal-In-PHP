<?php
require '../connection.php';


if (isset($_POST['edit'])) {
    $name = $_POST['nameE'];
    $phone = $_POST['phoneE'];
    $email = $_POST['emailE'];
    $address = $_POST['addressE'];
    $password = $_POST['curr_password'];

    if (empty($_POST['nameE']) || !preg_match("/^[a-zA-Z ]*$/", $_POST['nameE'])) {
        echo "<script>alert('Please enter a valid name')</script>";
        exit();
    }

    if (empty($_POST['phoneE']) || !preg_match("/^[0-9]*$/", $_POST['phoneE']) || strlen($_POST['phoneE']) != 10) {
        echo "<script>alert('Please enter a valid phone number')</script>";
        exit();
    }

    if (empty($_POST['emailE']) || !filter_var($_POST['emailE'], FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address')</script>";
        exit();
    }

    if (empty($_POST['addressE'])) {
        echo "<script>alert('Please enter a valid address')</script>";
        exit();
    }


    $teacherName = $_GET['t_name'];
    $check_password_query = "SELECT t_pass FROM teacher_record WHERE t_name = '$teacherName' AND t_pass = '$password'";
    $check_password_result = mysqli_query($connection, $check_password_query);

    if (mysqli_num_rows($check_password_result) > 0) {
        $update_query = "UPDATE teacher_record SET t_name='$name', t_phone='$phone', t_email='$email', t_address='$address'";

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $file_name = $_FILES['photo']['name'];
            $file_size = $_FILES['photo']['size'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_type = $_FILES['photo']['type'];
            move_uploaded_file($file_tmp, "teacher_profile/$file_name");

            $update_query .= ", t_image='$file_name'";
        }

        $update_query .= " WHERE t_name='$teacherName'";

        $update_result = mysqli_query($connection, $update_query);

        if ($update_result) {
            echo "<script>alert('Update Successfully')</script>";
            exit();
        } else {
            echo "<script>alert('Failed to Update');</script>";
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Wrong Current Password');</script>";
        echo "Incorrect password";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

    <style>
        body {
            background-color: rgb(226, 226, 226);

        }

        .fields {
            /* width: 40%; */

        }

        .fields input {
            background-color: #33736206;
            border: 0.7px solid #3373628c;
            height: 27px;
            border-radius: 4px;
            font-size: small;
            font-size: 15px;
        }

        .fields label {
            font-size: xx-small;
            color: #2D2D2D;
        }

        .studForm {
            background-color: white;
        }

        .academicHeading {
            background-color: #337362;
            color: white;
        }

        @media screen and (max-width:1193px) {
            .profession {
                font-size: 10px;
            }

        }

        @media screen and (max-width:1179px) {
            .stud-text {
                font-size: small;
            }

        }

        @media screen and (max-width:1056px) {
            .uniName {
                font-size: 12px;
            }

            .profession {
                font-size: 8px;
            }

            .nav-text {
                font-size: 14px;
            }

        }

        @media (max-width:1168px) and (min-width:1055px) {
            .profession {
                font-size: 11px;
            }
        }

        @media screen and (max-width:894px) {
            .uniName {
                font-size: 10px;
            }

            .profession {
                font-size: 6px;
            }

            .nav-text {
                font-size: 12px;
            }

            .menu-links .nav-link a .nav-text {
                display: none;

            }

            .menu-links .nav-link a i {
                margin-left: auto;
                margin-right: auto;

            }


        }

        @media screen and (max-width:576px) {
            .logo-text {
                display: none;
            }

            .logoImg {
                margin-left: auto;
                margin-right: auto;
            }

            .stud-text {
                display: none;
            }

            .stud-image {
                margin-left: auto;
                margin-right: auto;
            }

            .active-cont #menu-btn {
                /* background-color: red; */
                /* width: 20px; */
                height: 10px;
                margin-left: 30px;
            }
        }
    </style>
</head>

<body>

    <!-- Edit Profile -->

    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title editTitle" id="exampleModalLabel"><b>Update Account</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="firstname" class="col-sm-3 control-label mb-0">Teacher Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nameE" name="nameE"
                                    value="<?php echo $data['t_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="lastname" class="col-sm-3 control-label mb-0">Contact Info</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phoneE" name="phoneE"
                                    value="<?php echo $data['t_phone']; ?>">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="col-sm-3 control-label mb-0">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="emailE" name="emailE"
                                    value="<?php echo $data['t_email']; ?>">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="address" class="col-sm-3 control-label mb-0">Address</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="addressE"
                                    name="addressE"><?php echo $data['t_address']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="photo" class="col-sm-3 control-label mb-0">Photo</label>
                            <div class="col-sm-9">
                                <input type="file" id="photo" name="photo">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <label for="curr_password" class="col-sm-3 control-label mb-0">Current Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="curr_password" name="curr_password"
                                    placeholder="input current password to save changes" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-default btn-flat me-auto" data-bs-dismiss="modal"><i
                            class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-flat" name="edit"><i
                            class="fa fa-check-square-o"></i>
                        Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>