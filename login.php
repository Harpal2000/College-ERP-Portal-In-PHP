<?php

require 'connection.php';

session_start();

?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // if (empty($user) || empty($pass)) {
    //     echo "<script>alert('Please enter both username and password'); window.location.href='login.php';</script>";
    //     exit;
    // }


    $Query = "select * from login where username = '$user' and password = '$pass'";
    echo $Query;

    $result = mysqli_query($connection, $Query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["role"] == "Admin") {
                $_SESSION['LoginAdmin'] = $row["username"];
                header('Location: ../admin/admin-index.php');

            } else if ($row["role"] == "Teacher" and $row["account"] == "Activate") {
                $_SESSION['LoginTeacher'] = $row["username"];
                header('Location: ../teacher/teacher-index.php');

            } else if ($row["role"] == "Student" and $row["account"] == "Activate") {
                $_SESSION['LoginStudent'] = $row['username'];
                header('Location: ../student/student-index.php');
            }
        }

    } else {
        echo "Error: " . $Query . "<br>" . mysqli_error($Connection);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard: Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <style>
        body {
            margin - top: 20px;
            background: #cbd7e2;
        }

        #main-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .account-block {
            padding: 0;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
            position: relative;

        }

        .account-block .overlay {
            -webkit - box - flex: 1;
            -ms-flex: 1;
            flex: 1;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.4);
            /* background-color: white; */
        }

        .account-block .account-testimonial {
            text - align: center;
            color: #fff;
            position: absolute;
            margin: 0 auto;
            padding: 0 1.75rem;
            bottom: 3rem;
            left: 0;
            right: 0;
        }

        .text-theme {
            color: #337362;
        }

        .btn-theme {
            background - color: #337362;
            border-color: #337362;
            color: #fff;
        }

        .form-control:focus {
            box-shadow: none;
        }

        label.error {
            color: red;
            font-size: 0.8rem;
            font-weight: 400;
            margin-top: 5px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="main-wrapper" class="container">
        <div class="row justify-content-center align-middle my-auto">
            <div class="col-xl-10">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-lg-6 d-none d-lg-inline-block">
                                <div class="account-block rounded-right">
                                    <img src="/log.jpeg" alt="" class="img-fluid" width="390px" height="500x">
                                </div>
                            </div>
                            <div class="col-lg-6 align-middle ">
                                <div class="p-2 pe-5">
                                    <div class="mb-3">
                                        <h3 class="h4 font-weight-bold text-theme"><b>Dashboard Login</b></h3>
                                    </div>

                                    <h6 class="h5 mb-0">Welcome back!</h6>
                                    <p class="text-muted mt-2 mb-4">Enter your username and password to access dashboard
                                        panel.</p>

                                    <div id="regForm">
                                        <form id="loginForm" method="POST">
                                            <div class="form-group mb-4">
                                                <label for="username">User Name</label>
                                                <input type="text" class="form-control" name="username" id="username">
                                            </div>
                                            <div class="form-group mb-5">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" name="password"
                                                    id="password">
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <input type="submit" class="btn btn-success btn-theme text-center px-5"
                                                    name="login" id="login" value="Login">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('#loginForm').validate({
                    rules: {
                        username: {
                            required: true,
                        },
                        password: {
                            required: true,
                        },
                    },
                    messages: {
                        username: {
                            required: 'Please enter your username.',
                        },
                        password: {
                            required: 'Please enter your password.',
                        },
                    },
                });
            });
        </script>
</body>

</html>