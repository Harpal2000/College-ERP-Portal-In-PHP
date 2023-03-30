<?php

require '../connection.php';

?>
<?php
if (isset($_POST['upload-fee'])) {
    $course_id = $_POST['course_id'];
    $due_date = $_POST['due_date'];
    $batch = $_POST['batch'];
    $total_fee = $connection->query("SELECT total_amount/2 as total_fee FROM courses WHERE course='$course_id'")->fetch_assoc()['total_fee'];
    $address = $_POST['address'];
    $current_date = date("Y-m-d");
    // echo "<script>alert('$current_date')</script>";
    // echo "<script>alert('$due_date')</script>";
    // echo "<script>alert('$course_id')</script>";
    $students = $connection->query("SELECT * FROM student_record WHERE s_city = '$address'");
    while ($row = $students->fetch_assoc()) {
        $stu_name = $row['s_name'];
        $father_name = $row['father_name'];
        $s_dob = $row['s_dob'];
        $s_city = $row['s_city'];
        $s_email = $row['s_email'];
        $class = $row['class'];
        $s_sem = $row['s_sem'];
        $roll_no = $row['roll_no'];

        if ($address == 'Amritsar') {
            $current_fee = $total_fee + 825;
            // echo "<script>alert('$current_fee')</script>";
        } else if ($address == 'Bhikiwind') {
            $current_fee = $total_fee + 1624;
            // echo "<script>alert('$current_fee')</script>";
        } else if ($address == 'Tarn-taran') {
            $current_fee = $total_fee + 1624;
            // echo "<script>alert('$current_fee')</script>";
        } else if ($address == 'Gurdaspur') {
            $current_fee = $total_fee + 2342;
            // echo "<script>alert('$current_fee')</script>";
        } else {
            $current_fee = $total_fee;
        }
        $status = 'Pending';
        $connection->query("INSERT INTO fee_payment_record (`stu_name`,`f_name`,`s_dob`,`s_city`,`s_email`,`roll_no`,`s_sem`,`course`, `class`,`current_fee`,`fee_due_date`,`stu_batch`,`status`) VALUES ('$stu_name','$father_name','$s_dob','$s_city','$s_email','$roll_no','$s_sem','$course_id', '$class','$current_fee','$due_date','$batch','$status')");

        //$connection->query("INSERT INTO fee_payment_record ('stu_name','f_name','s_dob','s_city','s_email','roll_no','s_sem','course_id', 'class','address','current_fee','status') VALUES ('$stu_name','$father_name','$s_dob','$s_city','$s_email','$roll_no','$s_sem','$course_id', '$class', '$address','$current_fee','$status')");
    }
    echo "<script>alert('Assign Fee successfully')</script>";
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Upload Fee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .form-group {
            margin: 3rem 0 3rem 22rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#356155;color:white;">
                <h5 class="modal-title">Upload Fee</h5>
                <span class="float-end">
                    <a href="admin-index.php"><button type="button" class="btn"
                            style="background-color:white;color:black;">Main Dashboard</button></a></a>
                </span>
            </div>
            <div class=" modal-body pb-0 ">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group row mb-4">
                        <div class="col-sm-4">
                            <label for="course_id" class="form-label">Select Course</label>
                            <select class="form-select" id="course_id" name="course_id">
                                <option value=""></option>
                                <?php
                                $student = $connection->query("SELECT *,concat(course,'-',level) as class FROM courses order by course asc ");
                                while ($row = $student->fetch_assoc()):
                                    ?>
                                    <option value="<?php echo $row['course'] ?>"
                                        data-amount="<?php echo $row['total_amount'] / 2 ?>">
                                        <?php echo $row['class'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="total_fee" class="form-label">Course Fee per sem</label>
                            <input type="text" class="form-control" id="total_fee" name="total_fee"
                                value="<?php echo isset($total_fee) ? number_format($total_fee) : '' ?>" required
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <div class="col-sm-4">
                            <label for="address" class="form-label">Select City</label>
                            <select class="form-select" id="address" name="address">
                                <option value=""></option>
                                <?php
                                $student = $connection->query("SELECT DISTINCT s_city FROM student_record ");
                                while ($row = $student->fetch_assoc()):
                                    ?>
                                    <option value="<?php echo $row['s_city'] ?>">
                                        <?php echo $row['s_city'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="address" class="form-label">Enter Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date">
                        </div>
                    </div>
                    <div class="form-group row mb-8">
                        <div class="col-sm-8">
                            <label for="batch" class="form-label">Select Batch</label>
                            <select class="form-select" id="batch" name="batch">
                                <option value=""></option>
                                <?php
                                $student = $connection->query("SELECT DISTINCT s_batch FROM student_record ");
                                while ($row = $student->fetch_assoc()):
                                    ?>
                                    <option value="<?php echo $row['s_batch'] ?>">
                                        <?php echo $row['s_batch'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn" name="upload-fee" id="upload-fee"
                            style="background-color:#356155;color:white;width:20%;" value="Assign Fee">
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
    </script>
</body>

</html>