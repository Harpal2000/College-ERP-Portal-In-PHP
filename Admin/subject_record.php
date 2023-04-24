<?php

require '../connection.php';


if (isset($_GET['subject_code'])) {
    $subCode = $_GET['subject_code'];
    $qry = $connection->query("SELECT * FROM subject_record where subject_code= '$subCode'");
    $rowCode = $qry->fetch_assoc();
    foreach ($rowCode as $k => $val) {
        $$k = $val;
    }
}
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <title>Add Course and Fee</title>

    <style>
        td {
            vertical-align: middle !important;
        }

        td p {
            margin: unset
        }
    </style>

    <style>
        @media (min-width: 992px) {
            .modal-lg {
                max-width: 800px;
            }
        }
    </style>
    <style>
        span button {
            float: right;
        }
    </style>
</head>

<body>

    <?php
    $course_query = "SELECT * FROM subject_record ";

    $result = mysqli_query($connection, $course_query);
    ?>


    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row mb-4 mt-2">
                <div class="col-md-12">
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <b style="font-size:2rem;align-item:center;" class="display-1">All Subject Records</b>
                            <span>
                                <button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 py-2 ms-2"
                                    style="background-color:#356155;color:white;" data-bs-toggle="modal"
                                    data-bs-target=".myForm">
                                    <i class="bi bi-plus-lg"></i></b> Add Subjects
                                </button>
                                <a href="admin-index.php"><button type="button"
                                        class="btn btn-secondary btn-sm py-2 ms-2">Main
                                        Dashboard</button></a>
                            </span>

                        </div>
                        <div class="card-body">
                            <table id="myTable" class="table table-condensed table-bordered table-hover"
                                id="display_courses">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="">Subject Code</th>
                                        <th class="">Subject stream</th>
                                        <th class="">Subject Type</th>
                                        <th class="">Subject Name</th>
                                        <th class="">Semester</th>
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
                                                    <p>
                                                        <?php echo $row['subject_code'] ?>
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        <?php echo $row['subject_stream'] ?>
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        <?php echo $row['subject_type'] ?>
                                                    </p>
                                                </td>
                                                <td class="">
                                                    <p><small><i>
                                                                <?php echo $row['subject_name'] ?>
                                                            </i></small></p>
                                                </td>
                                                <td class="text-right">
                                                    <p>
                                                        <?php echo $row['subject_sem'] ?>
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary edit_course" type="button"
                                                        onclick="toggleUpdateButton()"
                                                        data-id="<?php echo $row['subject_code'] ?>">Edit</button>

                                                    <?php $sCode = $row['subject_code'] ?>
                                                    <button class="btn btn-sm btn-outline-danger delete_course"
                                                        onclick="confirmDelete('<?php echo $sCode ?>')"
                                                        type="button">Delete</button>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Table Panel -->
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade myForm" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#356155;color:white;">
                    <h5 class="modal-title editTitle" id="exampleModalLabel">Add Subjects</h5>
                </div>
                <div class="modal-body" id="updateModalBody">
                    <form action="" id="manage-subject" class="editForm">
                        <input type="hidden" name="id"
                            value="<?php echo isset($subject_code) ? $subject_code : 'nn' ?>">
                        <div class="form-group row mb-4">
                            <div class="col-sm-4">
                                <label for="sub_code" class="form-label">Enter Subject code:</label>
                                <input type="text" class="form-control" name="sub_code"
                                    value="<?php echo isset($subject_code) ? $subject_code : ''; ?>">
                            </div>
                            <div class="col-sm-4">
                                <label for="sub_name" class="form-label">Enter Subject Name:</label>
                                <input type="text" class="form-control" name="sub_name"
                                    value="<?php echo isset($subject_name) ? $subject_name : '' ?>">
                            </div>
                            <div class="col-sm-4">
                                <label for="sub_type" class="form-label">Enter Subject Type:</label>
                                <input type="text" class="form-control" name="sub_type"
                                    value="<?php echo isset($subject_type) ? $subject_type : '' ?>">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-sm-6">
                                <label for="s_stream" class="form-label">Select Subject Stream:</label>
                                <select class="form-control" name="s_stream">
                                    <option selected disabled>----select stream-----</option>
                                    <?php
                                    $student = $connection->query("SELECT * FROM teacher_record;");

                                    $uniqueStreams = array();
                                    while ($row = $student->fetch_assoc()):
                                        if (!in_array($row['t_stream'], $uniqueStreams)):
                                            $uniqueStreams[] = $row['t_stream'];
                                            ?>
                                            <option value="<?php echo $row['t_stream'] ?>"><?php echo $row['t_stream'] ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="sem" class="form-label">Select Semester:</label>
                                <select class="form-control" name="sem">
                                    <option selected disabled>----select Semester----</option>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="close-button">Close</button>
                    <button type="button" class="btn btn-primary" id='submit'
                        style="display:block;background-color:#356155;color:white;"
                        onclick="$('.modal form').submit()">Save</button>

                    <button type="button" class="btn btn-primary" id='Update_btn'
                        style="display:none;background-color:#356155;color:white;">Update</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });

    </script>

    <script>
        function confirmDelete(subjectCode) {
            //alert(subjectCode);
            if (confirm("Are you sure you want to delete this course?")) {

                $.ajax({
                    url: 'ajax2.php?action=delete_subject',
                    method: 'POST',
                    data: { subject_code: subjectCode },
                    success: function (data) {
                        alert('Data Delete successfully');
                        setTimeout(function () {
                            location.reload()
                        }, 1000)
                    }
                })

            }
        }
    </script>


    <script>
        $(document).ready(function () {
            $('#Update_btn').click(function () {
                $.ajax({
                    url: 'ajax2.php?action=update_sub',
                    type: 'POST',
                    data: $('.editForm').serialize(),
                    success: function (data) {
                        alert('Data updated successfully');
                        setTimeout(function () {
                            location.reload()
                        }, 1000)
                    }
                });
            });
        });
    </script>


    <script>
        function toggleUpdateButton() {
            document.getElementById("submit").style.display = "none";
            document.getElementById("Update_btn").style.display = "block";
        }
    </script>

    <script>
        document.getElementById("close-button").addEventListener("click", function () {
            location.reload();
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.edit_course').click(function () {
                editModal("Update Subject Record's", "subject_record.php?subject_code=" + $(this).attr('data-id'), "mid-large");

            })
        });

        window.editModal = function ($title = '', $url = '') {
            // alert($title)
            $.ajax({
                url: $url,
                error: function (xhr, status, error) {
                    console.error("Error in ajax request: " + error);
                    alert("An error occurred: " + error);
                },
                success: function (response) {
                    if (response) {
                        var $container = $(response).find('#updateModalBody');
                        $('#editModal .editTitle').html($title);
                        $('#editModal .modal-body').html($container);
                        $('[id^="manage-subject"]').prop('id', 'update-subject');

                        $('#editModal').modal({
                            show: true,
                            backdrop: 'static',
                            keyboard: false,
                            focus: true
                        });
                        $('#editModal').modal('show');
                    }
                }
            })
        }
    </script>


    <script>
        $(document).ready(function () {
            $('#manage-subject').submit(function (e) {
                e.preventDefault()

                $.ajax({
                    url: 'ajax2.php?action=manage_sub',
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    success: function (data) {
                        alert("Data Insert successfully!");
                        setTimeout(function () {
                            location.reload()
                        }, 1000)
                    }
                });
            });
        });
    </script>

</body>

</html>