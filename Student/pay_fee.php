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
    <title>Pay Fee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        #tableDiv {
            border: 1px solid black;
            padding: 2rem;
            background-color: #f8f9fa;
        }
    </style>

</head>

<body>
    <br>
    <div class="container">
        <a href="student-index.php"><button type="button" class="btn btn-secondary btn-sm">Main Dashboard</button></a>
    </div>
    <div id="records">
        <center>
            <br><br>
            <div id="tableDiv" style="width:80%">
                <h1 class="display-4">Verify Your Details and Pay Fee</h1>
                <hr color="black">
                <br><br>
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
                $query2 = "select * from courses where id = $course_id";

                $result2 = mysqli_query($connection, $query2);

                if ($result2 && mysqli_num_rows($result2) > 0) {
                    while ($data2 = mysqli_fetch_assoc($result2)) {
                        $course_desc = $data2['description'];
                        $course_name = $data2['course'];
                        $course_dur = $data2['level'];
                        $course_amount = $data2['total_amount'];
                    }
                } else {
                    echo 'No Data Available';
                }

                ?>

                <table id="myTable" class="display table-condensed table-bordered table-hover" style="width:100%"
                    cellpadding="5">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            ?>
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <td>
                                        <?php echo $data['s_name']; ?>
                                    </td>
                                <tr>
                                    <th>Father Name</th>
                                    <td>
                                        <?php echo $data['father_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Roll No</th>
                                    <td>
                                        <?php echo $data['roll_no']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Information</th>
                                    <td>
                                        <small><b>Course: </b><i>
                                                <?php echo $course_desc . " " . "( " . "$course_name" . " )"; ?>
                                            </i></small><br>
                                        <small><b>Course Duration: </b><i>
                                                <?php echo $course_dur; ?>
                                            </i></small><br>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Current Semester</th>
                                    <td>
                                        <?php echo $data['s_sem']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Current Semester Total fee</th>
                                    <td>
                                        <?php echo $course_amount / 2; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pay fee</th>
                                    <td>
                                        <button id="rzp-button1">Pay Now</button>
                                    </td>
                                </tr>
                            </thead>

                            <?php
                        }
                    } else {
                        echo "NO data found";
                    }
                    ?>
                    </tbody>
                </table>
                <div>
        </center>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <script>
        var options = {
            "key": "rzp_test_tBM3XofEO81gUF",
            "amount": "<?php echo ($course_amount / 2) * 100; ?>",
            "name": "AGC, Amritsar",
            "description": "<transaction_description>",
            "image": "<merchant_logo>",
            "handler": function (response) {
                alert('Payment Successful!');
            },
            "prefill": {
                "name": "<customer_name>",
                "email": "<customer_email>",
                "contact": "<customer_phone>"
            },
            "notes": {
                "address": "<customer_address>"
            },
            "theme": {
                "color": "#F37254"
            }
        };
        var rzp1 = new Razorpay(options);
        document.getElementById('rzp-button1').onclick = function (e) {
            rzp1.open();
            e.preventDefault();
        }
    </script>


</body>

</html>