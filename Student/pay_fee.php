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
    <style>
        @media print {
            #tableDiv.no-border {
                border: none;
            }

            .head {
                visibility: hidden;
            }
        }
    </style>

</head>

<body>
    <br>
    <div id="records">
        <center>
            <br>
            <div id="tableDiv" style="width:80%">
                <div class="head">
                    <h1 class="display-4" style="font-size:2.5rem;">Verify Your Details and Pay Fee</h1>
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

                <table id="myTable" class="display table-condensed table-bordered table-hover" style="width:100%"
                    cellpadding="5">
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
                                    <th>Information</th>
                                    <td>
                                        <small><b>Course: </b><i>
                                                <?php echo $course_desc . " " . "( " . "$course_name" . " )"; ?>
                                            </i></small><br>
                                        <small><b>Course Duration: </b><i>
                                                <?php echo $course_dur; ?>
                                            </i></small><br>
                                        <small><b>E-Mail: </b><i>
                                                <?php echo $data2['s_email']; ?>
                                            </i></small><br>
                                        <small><b>City: </b><i>
                                                <?php echo $data2['s_city']; ?>
                                            </i></small><br>

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
                                <tr class="head">
                                    <th>Pay fee</th>
                                    <td>
                                        <?php
                                        if ($data2['status'] == 'Pending') {
                                            ?>
                                            <form method="POST">
                                                <input type="text" name="RollNO" id=rollNO value="<?php echo $data2['roll_no'] ?>">
                                                <button id="pay-now-button" class="btn btn-primary btn-sm">Pay Now</button>
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
                "color": "#528FF0"
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