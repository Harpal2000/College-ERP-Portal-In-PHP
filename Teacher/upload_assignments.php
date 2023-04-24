<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginTeacher'])) {
    echo "<script>alert('session break')</script>";
    header('Location:../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload Assignments</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/bootstrap/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: rgb(226, 226, 226);
            display: flex;
            justify-content: center;
        }

        table {
            width: 70% !important;
        }

        #as_no {
            width: 50% !important;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .header-sec {
            display: flex;
            color: white;
            background-color: #337362;
            padding: 1%;
            display: flex;
            align-items: center;
        }
    </style>

</head>

<?php
if (isset($_GET['t_name'])) {
    $t_name = $_GET['t_name'];
}

if (isset($_POST['submit_assignment'])) {
    if (isset($_FILES['assignment_file'])) {
        $assign_no = $_POST['assignment_no'];
        //echo "<script>alert($assign_no)</script>";
        $assignment_file = $_FILES['assignment_file'];

        $allowed_extensions = ['pdf', 'doc', 'docx'];
        $max_file_size = 10 * 1024 * 1024;

        if (
            $assignment_file['error'] == UPLOAD_ERR_OK &&
            in_array(strtolower(pathinfo($assignment_file['name'], PATHINFO_EXTENSION)), $allowed_extensions) &&
            $assignment_file['size'] <= $max_file_size
        ) {

            $file_name = uniqid() . '.' . pathinfo($assignment_file['name'], PATHINFO_EXTENSION);


            if (move_uploaded_file($assignment_file['tmp_name'], 'assignment_data/' . $file_name)) {
                $class_name = $_POST['class_name'];
                $subject_name = $_POST['subject_name'];
                $subject_code = $_POST['subject_code'];
                $semester = $_POST['semester'];
                $assign_file = $file_name;

                $query = "INSERT INTO assignment_record (subject_code, subject_name,class,teacher_name,sem, assign_file,assign_no) VALUES ('$subject_code', '$subject_name', '$class_name','$t_name', '$semester', '$assign_file','$assign_no')";
                if (mysqli_query($connection, $query)) {
                    echo "<script>alert('Assignment uploaded successfully.');</script>";

                } else {
                    echo "Error in Query: " . $Query . "<br>" . mysqli_error($connection);
                }
            } else {
                echo "<script>alert('Failed to upload assignment. Please try again.')</script>";
            }
        } else {
            echo "<script>alert('Invalid file format or size. Only PDF, DOC, and DOCX files are allowed with a maximum size of 10MB.')</script>";
        }
    }
}


?>


<body>
    <center class="mt-2" style="background-color:white; width:98vw; height:95vh">
        <?php

        if (isset($_GET['t_name'])) {
            $t_name = $_GET['t_name'];
        }
        $query = "SELECT DISTINCT subject_name,subject_code,class,semester FROM `timetable` WHERE faculty_name =
        '$t_name' and subject_type = 'lecture'";
        $result = mysqli_query($connection, $query);
        ?>
        <div class="header-sec">
            <a href="../teacher/teacher-index.php"><button type="button" class="btn"
                    style="background-color:white;color:black;"> <i
                        class='bx bx-home-alt icon'></i>Dashboard</button></a>
            <div style="margin: auto; text-align:center;">
                <h2>Upload Your Assignments Here</h2>
            </div>
        </div>


        <!-- <hr color="black" width="70%"> -->
        <div style="width:85%;margin-top:3%">
            <table border="1" class="table table-condensed table-bordered mt-4">
                <caption align="top">Assignment-1</caption>
                <tr align="center" style="color:white; background-color:#337362">
                    <th>subject_code</th>
                    <th>Subject_name</th>
                    <th>class</th>
                    <th>Upload Assignment</th>
                    <th>View Assignment</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <?php
                    $assign_no = 1;
                    $subject_code = $row['subject_code'];
                    $ass_record_query = "SELECT * FROM `assignment_record` WHERE subject_code = '$subject_code' AND assign_no = $assign_no AND teacher_name = '$t_name'";
                    $ass_record_result = mysqli_query($connection, $ass_record_query);
                    $already_uploaded = mysqli_num_rows($ass_record_result) > 0;
                    ?>
                    <tr align="center">
                        <td>
                            <?php echo $row['subject_code']; ?>
                        </td>
                        <td>
                            <?php echo $row['subject_name']; ?>
                        </td>
                        <td>
                            <?php echo $row['class']; ?>
                        </td>
                        <td>
                            <?php if ($already_uploaded) { ?>
                                Already Uploaded
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary" onclick="fetchInputValue()" data-bs-toggle="modal"
                                    data-class="<?php echo $row['class']; ?>" data-subject="<?php echo $row['subject_name']; ?>"
                                    data-sem="<?php echo $row['semester']; ?>" data-code="<?php echo $subject_code; ?>"
                                    data-target="#assignmentModal">Upload Assignment</button>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            $assign_no = 1;
                            $ass_record_query = "SELECT assign_file FROM `assignment_record` WHERE subject_code = '$subject_code' AND assign_no = $assign_no AND teacher_name = '$t_name'";
                            $ass_record_result = mysqli_query($connection, $ass_record_query);
                            $already_uploaded = mysqli_num_rows($ass_record_result) > 0;

                            if ($already_uploaded) {
                                while ($row = mysqli_fetch_assoc($ass_record_result)) {
                                    $assign_file = $row['assign_file'];
                                    ?>
                                    <a href="assignment_data/<?php echo $row['assign_file']; ?>" target="_blank"><button
                                            type="button" class="btn btn-primary btn-sm">
                                            Download
                                        </button></a>
                                    <?php
                                }
                            } else {
                                ?>
                                <button type="button" class="btn btn-danger btn-sm" disabled>
                                    Not Uploaded yet!
                                </button>
                                <?php
                            } ?>
                        </td>

                    </tr>
                <?php } ?>
            </table>



            <!-- Assignment-2 -->
            <?php

            if (isset($_GET['t_name'])) {
                $t_name = $_GET['t_name'];
            }
            $query = "SELECT DISTINCT subject_name,subject_code,class,semester FROM `timetable` WHERE faculty_name =
        '$t_name' and subject_type = 'lecture'";
            $result = mysqli_query($connection, $query);
            ?>
            <table border="1" class="table table-condensed table-bordered mt-5">
                <caption align="top">Assignment-2</caption>
                <tr align="center" style="color:white; background-color:#337362">
                    <th>subject_code</th>
                    <th>Subject_name</th>
                    <th>class</th>
                    <th>Upload Assignment</th>
                    <th>View Assignment</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <?php
                    $assign_no = 2;
                    $subject_code = $row['subject_code'];
                    $ass_record_query = "SELECT * FROM `assignment_record` WHERE subject_code = '$subject_code' AND assign_no = $assign_no";
                    $ass_record_result = mysqli_query($connection, $ass_record_query);
                    $already_uploaded = mysqli_num_rows($ass_record_result) > 0;
                    ?>
                    <tr align="center">
                        <td>
                            <?php echo $row['subject_code']; ?>
                        </td>
                        <td>
                            <?php echo $row['subject_name']; ?>
                        </td>
                        <td>
                            <?php echo $row['class']; ?>
                        </td>
                        <td>
                            <?php if ($already_uploaded) { ?>
                                Already Uploaded
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary" onclick="fetchInputValue()" data-bs-toggle="modal"
                                    data-class="<?php echo $row['class']; ?>" data-subject="<?php echo $row['subject_name']; ?>"
                                    data-sem="<?php echo $row['semester']; ?>" data-code="<?php echo $subject_code; ?>"
                                    data-target="#assignmentModal">Upload Assignment</button>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            $assign_no = 2;
                            $ass_record_query = "SELECT assign_file FROM `assignment_record` WHERE subject_code = '$subject_code' AND assign_no = $assign_no";
                            $ass_record_result = mysqli_query($connection, $ass_record_query);
                            $already_uploaded = mysqli_num_rows($ass_record_result) > 0;

                            if ($already_uploaded) {
                                while ($row = mysqli_fetch_assoc($ass_record_result)) {
                                    $assign_file = $row['assign_file'];
                                    ?>
                                    <a href="assignment_data/<?php echo $row['assign_file']; ?>" target="_blank"><button
                                            type="button" class="btn btn-primary btn-sm">
                                            Download
                                        </button></a>
                                    <?php
                                }
                            } else {
                                ?>
                                <button type="button" class="btn btn-danger btn-sm" disabled>
                                    Not Uploaded yet!
                                </button>
                                <?php
                            } ?>
                        </td>

                    </tr>
                <?php } ?>
            </table>
        </div>
    </center>


    <!-- Assignment upload modal -->
    <div class="modal fade" id="assignmentModal" tabindex="-1" role="dialog" aria-labelledby="assignmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignmentModalLabel">Upload Assignment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group row mb-2">
                            <div class="col-sm-12 mb-4">
                                <label for="Assignment" class="form-label">Enter Assignment Number</label>
                                <input type="text" name="assignment_no" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-sm-12 mb-4">
                                <label for="Assignment" class="form-label">Upload Assignment (File size < 10MB) <p
                                        style="margin:0;">
                                        </p></label>
                                <input type="file" name="assignment_file" class="form-control" required>
                            </div>
                        </div>
                        <input type="hidden" name="class_name" id="class_name" readonly>
                        <input type="hidden" name="subject_name" id="subject_name" readonly>
                        <input type="hidden" name="subject_code" id="subject_code" readonly>
                        <input type="hidden" name="semester" id="semester" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_assignment">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#assignmentModal').modal({
                show: false
            });
        });

        $('button[data-target="#assignmentModal"]').on('click', function () {
            var button = $(this);
            var class_name = button.data('class');
            var subject_name = button.data('subject');
            var semester = button.data('sem');
            var subject_code = button.data('code');
            $('#class_name').val(class_name);
            $('#subject_name').val(subject_name);
            $('#semester').val(semester);
            $('#subject_code').val(subject_code);
            $('#assignmentModal').modal('show');
        });
    </script>

</body>


</html>