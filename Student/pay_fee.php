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
    <title>Dashboard: Pay Fee</title>
    <link rel="stylesheet" href="/extra/nav.css">
    <link rel="stylesheet" href="/bootstrap/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text&display=swap" rel="stylesheet">
    <style>
        body {

            background-color: rgb(226, 226, 226);
        }

        .pay-fee-btn button {
            margin-top: 20px;
            padding: 10px;
            width: 90%;
        }
    </style>


</head>

<body>








    <div style="margin:10px; ">
        <!-- sideNavbar  -->
        <div class="side-navbar active-nav d-flex flex-column" id="sidebar" style="height:97%; border-radius: 10px;">
            <div class="logo d-flex">
                <div class="logoImg " style="display: flex;justify-content: center;">
                    <img src="/images/Keystone logo - png.png" alt="" width="45px" height="45px"
                        style="margin-top: auto; margin-bottom: auto;">
                </div>
                <div class="logo-text text-center pt-2 ps-2">
                    <span class="uniName">Keystone University</span><br>
                    <span class="profession align-top " style="text-align: center;">Pharmacy | Law | Engineering</span>
                </div>
            </div>

            <div class="studName mx-2 d-flex flex-lg-row flex-sm-column ">
                <span class="stud-image"><a href="stuProfile.php" style="text-decoration:none;color:white;">
                        <?php
                        $stu_roll_no = $_SESSION['LoginStudent'];
                        $query = "select * from student_record where roll_no = $stu_roll_no";

                        $result = mysqli_query($connection, $query);
                        ?>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                                ?>
                                <?php
                                $image = $data['s_image'];
                                $image_src = "../Admin/student_image/" . $image;
                                ?>
                                <img src="<?php echo $image_src; ?>" alt="" width="35px">


                        </span>
                        <div class="stud-text text " style="font-weight: 100; text-align: center; margin-left: 10px;">
                            <span>
                                <?php echo $data['s_name']; ?>
                            </span> </a>
                        </div>

                        <?php
                            }
                        } else {
                            echo 'No Data Available';
                        }

                        ?>
            </div>


            <ul class="menu-links " style="padding-left: 0;">
                <li class="nav-link">
                    <a href="student-index.php" class="mx-auto" style="">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text ">Dashboard </span>

                    </a>
                </li>

                <li class="nav-link">
                    <a href="view_assignments.php">
                        <i class='bx bx-bar-chart-alt-2 icon'></i>
                        <span class="text nav-text">Assignments</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="internal_marks.php">
                        <i class='bx bx-pie-chart-alt icon'></i>
                        <span class="text nav-text">Internal Marks</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="stuProfile.php">
                        <i class='bx bx-user icon'></i>
                        <span class="text nav-text">Profile</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="pay_fee.php">
                        <i class='bx bx-wallet icon'></i>
                        <span class="text nav-text">Pay Fee</span>
                    </a>
                </li>

                <!-- <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-wallet icon'></i>
                        <span class="text nav-text">Fee Receipt</span>
                    </a>
                </li> -->
                <li class="logout text-center nav-link"
                    style="position: absolute;bottom: 10px; right: 0; left: 0;text-align: center;">
                    <a href="#">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- toogle icon  -->
        <div class="ps-lg-5 ps-md-4  pt-0 my-container active-cont" style="display: flex;">
            <a class="btn border-0 mt-0" id="menu-btn" style="height: 1%;">
                <i class="bx bx-menu"></i>
            </a>
            <div class="container ms-3  align-items-center" style="width: 90%;">
                <div class="row d-flex mb-4" style="margin-top:5px">
                    <div class="col ms-0" style="padding-left: 0;">
                        <div class="text" style="display:flex; flex-direction: column;color: black;font-size:26px">
                            <b>ACADEMIC CONTENT</b><span
                                style="color: #570706 ;font-size:xx-small;margin-top: -10px;"><b>VIEW AND DOWNLOAD YOUR
                                    ACADEMIC CONTENT</b></span>
                        </div>
                    </div>
                </div>

                <div id="records" style="background-color:white;border-radius:10px;padding-bottom:20px">
                    <center>
                        <br>
                        <div id="tableDiv" style="width:100%;margin-top:-30px;
 ">
                            <div class="head " style="background-color:#337362;margin:0;padding:0;border-top-left-radius:10px;
    border-top-right-radius:10px;">
                                <h3 class="pt-1 pb-0" style="color:white;display:flex;  justify-content: center;
  align-items: center;">Verify Your Details and Pay Fee</h1>
                                    <hr color="black">
                            </div>
                            <br>
                            <?php
                            $stu_roll_no = $_SESSION['LoginStudent'];
                            $query = "select * from student_record where roll_no = $stu_roll_no";

                            $result = mysqli_query($connection, $query);
                            ?>

                            <?php
                            $query_course = "select * from student_record where roll_no = $stu_roll_no";
                            // echo "<script>alert('$query_course')</script>";
                            
                            $result_c = mysqli_query($connection, $query_course);
                            if (mysqli_num_rows($result_c) > 0) {
                                while ($data = mysqli_fetch_assoc($result_c)) {
                                    $course_id = $data['s_course'];
                                    // echo "<script>alert('$course_id')</script>";
                                }
                            }
                            ?>
                            <?php
                            $query_course = "select * from courses where id = $course_id";
                            // echo "<script>alert('$query_course')</script>";
                            
                            $result_c = mysqli_query($connection, $query_course);
                            if (mysqli_num_rows($result_c) > 0) {
                                while ($data = mysqli_fetch_assoc($result_c)) {
                                    $course_name = $data['course'];
                                    $course_desc = $data['description'];
                                    $course_dur = $data['level'];
                                    // echo "<script>alert('$course_id')</script>";
                                }
                            }
                            ?>


                            <?php
                            $stu_roll_no = $_SESSION['LoginStudent'];
                            $query2 = "select * from fee_payment_record where roll_no = '$stu_roll_no'";

                            $result2 = mysqli_query($connection, $query2);


                            ?>

                            <table id="myTable" class="display table-condensed table-bordered table-hover"
                                style="width:97%;margin-top:-3%;" cellpadding="8">
                                <?php
                                if ($result2 && mysqli_num_rows($result2) > 0) {
                                    while ($data2 = mysqli_fetch_assoc($result2)) {
                                        $fee = $data2['current_fee'];
                                        ?>
                                        <thead>
                                            <tr>
                                                <th>Student Batch</th>
                                                <td>
                                                    <?php echo $data2['stu_batch']; ?>
                                                </td>
                                            <tr>
                                            <tr>
                                                <th>Fee Due Date</th>
                                                <td>
                                                    <?php echo $data2['fee_due_date']; ?>
                                                </td>
                                            <tr>
                                            <tr>
                                                <th>Student Name</th>
                                                <td>
                                                    <?php echo $data2['stu_name']; ?>
                                                </td>
                                            <tr>
                                                <th>Father Name</th>
                                                <td>
                                                    <?php echo $data2['f_name']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Roll No</th>
                                                <td>
                                                    <?php echo $data2['roll_no']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>course</th>
                                                <td>
                                                    <?php echo $course_desc . " " . "( " . "$course_name" . " )"; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Course Duration</th>
                                                <td>
                                                    <?php echo $course_dur; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <th>E-Mail</th>
                                                <td>
                                                    <?php echo $data2['s_email']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <th>City</th>
                                                <td>
                                                    <?php echo $data2['s_city']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Current Semester</th>
                                                <td>
                                                    <?php echo $data2['s_sem']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Current Semester Total fee</th>
                                                <td>
                                                    <?php echo 'Rs' . " " . $data2['current_fee']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Payment Status</th>
                                                <td>
                                                    <?php
                                                    if ($data2['status'] == 'Pending') {
                                                        ?>
                                                        <button type="button" class="btn btn-danger btn-sm" disabled>
                                                            <?php echo $data2['status']; ?>
                                                        </button>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <button type="button" class="btn btn-success btn-sm" disabled>
                                                            <?php echo $data2['status']; ?>
                                                        </button>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </thead>
                                        </tbody>
                                    </table>
                                    <div class="pay-fee-btn">
                                        <?php
                                        if ($data2['status'] == 'Pending') {
                                            ?>
                                            <form method="POST">
                                                <input type="hidden" name="RollNO" id=rollNO
                                                    value="<?php echo $data2['roll_no'] ?>">
                                                <button id="pay-now-button" class="btn btn-primary btn-sm">Pay
                                                    Now</button>
                                            </form>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="printReceipt()">
                                                Print E-Receipt
                                            </button>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <?php
                                    }
                                } else {
                                    echo "NO data found";
                                }
                                ?>
                            <div>
                    </center>
                </div>

                <div class="row attendance-table ">


                </div>
            </div>
        </div>

        <!-- paala da code  -->

        <script>
            var menu_btn = document.querySelector("#menu-btn");
            var sidebar = document.querySelector("#sidebar");
            var container = document.querySelector(".my-container");
            menu_btn.addEventListener("click", () => {
                sidebar.classList.toggle("active-nav");
                container.classList.toggle("active-cont");
            });

        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

        <script>
            function printReceipt() {
                $('#tableDiv').addClass('no-border');
                window.print();
            }
        </script>

        <script>
            var options = {
                "key": "rzp_test_sf7GUFfzk2z4R7",
                "amount": "62430",
                "name": "AGC, Amritsar",
                "description": "<transaction_description>",
                "image": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK5gHeXeFSrSujf1v_BMv7wgb1zR2e4l2OAA&usqp=CAU",
                handler: function (response) {
                    var rollNO = $("#rollNO").val();
                    $.ajax({
                        url: 'update_payment.php',
                        type: 'POST',
                        data: {
                            payment_status: 'success',
                            rollNO: rollNO
                        },
                        success: function (response) {
                            alert("Payment Done");
                        },
                        error: function () {
                            alert("Error updating database");
                        }
                    });
                },
                "prefill": {
                    "name": "John Doe",
                    "email": "john@example.com",
                    "contact": "9999999999"
                },
                "theme": {
                    "color": "#337362"
                }
            };

            var rzp1 = new Razorpay(options);
            document.getElementById('pay-now-button').onclick = function (e) {
                rzp1.open();
                e.preventDefault();
            }
        </script>


</body>

</html>