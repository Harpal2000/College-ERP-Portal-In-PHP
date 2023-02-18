<?php

require 'connection.php';
?>





<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Add Course and Fee</title>

    <style>
        @media (min-width: 992px) {
            .modal-lg {
                max-width: 1300px;
            }
        }
    </style>
</head>

<body>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row mb-4">
                            <div class="col-sm-6">
                                <label for="sub_id" class="form-label">Enter Subject Id:</label>
                                <input type="text" class="form-control" name="sub_id">
                            </div>
                            <div class="col-sm-6">
                                <label for="sub_name" class="form-label">Enter Subject Name:</label>
                                <input type="text" class="form-control" name="sub_name">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-sm-6">
                                <label for="s_stream" class="form-label">Select Subject Stream:</label>
                                <select class="form-control" name="s_stream">
                                    <option selected disabled></option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="s_teacher" class="form-label">Select Subject Teacher:</label>
                                <select class="form-control" name="s_teacher">
                                    <option selected disabled></option>
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                    <option>Option 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-sm-6">
                                <label for="sem" class="form-label">Select Semester:</label>
                                <select class="form-control" name="sem">
                                    <option selected disabled></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>




</body>

</html>


<?php

$student = $connection->query("SELECT * FROM teacher_record;");

while ($row = $student->fetch_assoc()):
    ?>

    <option value="<?php echo $row['id'] ?>" data-amount="<?php echo $row['total_amount'] ?>"><?php echo $row['class'] ?>
    </option>
<?php endwhile; ?>
?>



<script>
    $(document).ready(function () {
        $('form').on('submit', function (e) {
            e.preventDefault(); // prevent the form from submitting normally
            var formData = $(this).serialize(); // collect the form data
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: formData,
                success: function (response) {
                    console.log(response); // log the response from ajax.php
                }
            });
        });
    });
</script>


<thead>
    <tr>
        <th class="text-center">#</th>
        <th class="">Subject Code / Name</th>
        <th class="">Time-slot / Room-no</th>
        <th class="">Faculty Name</th>
        <th class="">Day</th>
        <th class="">Subject Type</th>
        <th class="text-center">Action</th>
    </tr>
</thead>
<tbody>
    <?php
    $i = 1;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td class="text-center">
                    <?php echo $i++ ?>
                </td>
                <td>
                    <p><b>
                            <?php echo $row['subject_code'] . "  " . "( " . $row['subject_name'] . " )" ?>
                        </b></p>
                </td>
                <td class="">
                    <p><small><i><b>
                                    <?php echo $row['time_slot'] . "  " . "( " . $row['room_no'] . " )" ?>
                                </b></i></small></p>
                </td>
                <td class="text-right">
                    <p><b>
                            <?php echo $row['faculty_name'] ?>
                        </b></p>
                </td>
                <td class="">
                    <p><small><i><b>
                                    <?php echo $row['day'] ?>
                                </b></i></small></p>
                </td>
                <td class="">
                    <p><small><i><b>
                                    <?php echo $row['sub_type'] ?>
                                </b></i></small></p>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-primary edit_course" type="button">Edit</button>
                    <button class="btn btn-sm btn-outline-danger delete_course" type="button">Delete</button>
                </td>
            </tr>
            <?php
        }
    }
    ?>


    <form>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="s_id">Enter Student Id:</label>
                <input type="text" class="form-control" name="s_id" id="s_id">
            </div>
            <div class="form-group col-md-4">
                <label for="img">Upload Image:</label>
                <input type="file" name="img" id="img" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="username">Enter Student Name:</label>
                <input type="text" name="username" id="username" class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="roll_no">Enter Roll_no:</label>
                <input type="text" name="roll_no" id="roll_no" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="father_name">Enter Father Name:</label>
                <input type="text" name="father_name" id="father_name" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="mother_name">Enter Mother Name:</label>
                <input type="text" name="mother_name" id="mother_name" class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="gender">Enter Gender:</label>
                <div class="form-check form-check-inline">
                    <input type="radio" name="gender" value='Female' class="form-check-input">
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="gender" value='Male' class="form-check-input">
                    <label class="form-check-label" for="male">Male</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="dob">Enter D.O.B:</label>
                <input type="date" name="dob" id="dob" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="course_id">Select Course:</label>
                <select class="form-control" id="course_id" name="course_id">
                    <option value=""></option>
                    <?php
                    $student = $connection->query("SELECT *,concat(course,'-',level) as class FROM courses order by course asc ");
                    while ($row = $student->fetch_assoc()):
                        ?>
                        <option value="<?php echo $row['id'] ?>" data-amount="<?php echo $row['total_amount'] ?>">
                            <?php echo $row['class'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="total_fee">Annual Course Fee:</label>
                <input type="text" class="form-control" id="total_fee" name="total_fee"
                    value="<?php echo isset($total_fee) ? number_format($total_fee) : '' ?>" required readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="password">Enter Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group col-md-4">
                <label for="email">Enter E-mail:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="phone">Enter Mobile-no:</label>
                <input type="text" class="form-control" id="phone" name="phone" maxlength="10">
            </div>
            <div class="form-group col-md-4">
                <label for="class">Enter Class:</label>
                <input type="text" class="form-control" id="class" name="class">
            </div>
            <div class="form-group col-md-4">
                <label for="address">Enter Address:</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="city">Enter City:</label>
                <input type="text" class="form-control" id="city" name="city">
            </div>
            <div class="form-group col-md-4">
                <label for="pin" class="col-sm-2 col-form-label">Enter Pin-code:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="pin" name="pin">
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="state" class="col-sm-2 col-form-label">Enter State:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="state" name="state">
                </div>
            </div>
        </div>
        <div class="form-row">
            <label for="country" class="col-sm-2 col-form-label">Enter Country:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="country" name="country">
            </div>
            <div class="form-group row">
                <label for="batch" class="col-sm-2 col-form-label">Enter Batch:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="batch" name="batch">
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="state" class="col-sm-2 col-form-label">Enter State:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="state" name="state">
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" name="r-btn" id="r-btn" value="Register">
    </form>