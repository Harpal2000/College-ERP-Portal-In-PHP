<?php
require '../connection.php';


if (isset($_POST['edit'])) {
    $name = $_POST['nameE'];
    $phone = $_POST['phoneE'];
    $email = $_POST['emailE'];
    $password = $_POST['passwordE'];

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

    if (empty($_POST['passwordE'])) {
        echo "<script>alert('Please enter a valid password')</script>";
        exit();
    }



    $update_query = "UPDATE teacher_record SET t_phone='$phone', t_email='$email', t_pass='$password' WHERE t_name='$name'";

    $update_result = mysqli_query($connection, $update_query);

    if ($update_result) {
        echo "<script>alert('Update Successfully');</script>";
        echo `<script>window.location.href="teach_profile.php";</script>`;
        exit();
    } else {
        echo "<script>alert('Failed to Update');</script>";
        echo "Error updating record: " . mysqli_error($conn);
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

        .modal-content {
            width: 80%;
            max-width: 600px;
            height: 85%;
            max-height: 640px;
            padding: 20px;
            margin: auto;
        }

        .cont-label {
            font-weight: bold;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-close:focus {
            box-shadow: none;
        }
    </style>
</head>

<body>

    <!-- Edit Profile -->

    <div class="modal fade" id="edit-<?php echo $data['t_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title editTitle" id="exampleModalLabel"><b>Update Account</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group row mb-3">
                            <label for="firstname" class="col-sm-3 col-form-label cont-label">Teacher Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nameE" name="nameE" readonly
                                    value="<?php echo $data['t_name']; ?>">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="lastname" class="col-sm-3 col-form-label cont-label">Contact Info</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phoneE" name="phoneE" max-length="10"
                                    value="<?php echo $data['t_phone']; ?>">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="email" class="col-sm-3 col-form-label cont-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="emailE" name="emailE"
                                    value="<?php echo $data['t_email']; ?>">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="address" class="col-sm-3 col-form-label cont-label">Address</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="addressE"
                                    name="addressE"><?php echo $data['t_address']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="address" class="col-sm-3 col-form-label cont-label">Password</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="passwordE"
                                    name="passwordE"><?php echo $data['t_pass']; ?></textarea>
                            </div>
                        </div>


                </div>
                <div class="modal-footer justify-content-end">
                    <!-- <button type="button" class="btn btn-default btn-flat me-auto" data-bs-dismiss="modal"><i
                            class="fa fa-close"></i> Close</button> -->
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