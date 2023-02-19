<?php

require '../connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qry = $connection->query("SELECT * FROM timetable where id =" . $id);
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
                max-width: 1000px;
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
    $course_query = "SELECT * FROM subject_record INNER JOIN timetable ON subject_record.subject_code = timetable.subject_code ";

    $result = mysqli_query($connection, $course_query);
    ?>


    <div class="container-fluid">
        <div class="row mb-4 mt-2">
            <div class="col-md-12">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b style="font-size:2rem;align-item:center;" class="display-1">Time-Table
                            Record</b>
                        <span>
                            <a href="admin-index.php"><button type="button"
                                    class="btn btn-secondary btn-sm py-2 ms-2">Main
                                    Dashboard</button></a>
                            <button type="button" style="background-color:#356155;color:white;"
                                class="btn btn-block btn-sm col-sm-2 py-2 ms-2" data-bs-toggle="modal"
                                data-bs-target=".timeModal">
                                <i class="bi bi-plus-lg"></i> Add Time-table Record
                            </button>
                        </span>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="myTable" class="table table-condensed table-bordered table-hover"
                            id="display_courses">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Subject Code</th>
                                    <th class="">Subject Name</th>
                                    <th class="">Time-slot</th>
                                    <th class="">Room-no</th>
                                    <th class="">Faculty Name</th>
                                    <th class="">Day</th>
                                    <th class="">Subject Type</th>
                                    <th class="">Class Group</th>
                                    <th class="">Class</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $start_time = $row['start_time'];
                                        $end_time = $row['end_time'];
                                        // check if start_time is in 12-hour format
                                        if (date('h:i A', strtotime($start_time)) == $start_time) {
                                        } else {
                                            $start_time = date('h:i A', strtotime($start_time));
                                        }

                                        // check if end_time is in 12-hour format
                                        if (date('h:i A', strtotime($end_time)) == $end_time) {
                                        } else {
                                            $end_time = date('h:i A', strtotime($end_time));
                                        }

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
                                                    <?php echo $row['subject_name'] ?>
                                                </p>
                                            </td>
                                            <td class="">
                                                <p><small>
                                                        <?php if ($start_time >= '9:00' or $end_time <= '11:59') {
                                                            echo $start_time . " - " . $end_time;
                                                        } else {
                                                            echo $start_time . " - " . $end_time;
                                                        }
                                                        ?>
                                                    </small></p>
                                            </td>
                                            <td class="">
                                                <p><small>
                                                        <?php echo $row['room_no'] ?>
                                                    </small></p>
                                            </td>
                                            <td class="text-right">
                                                <p>
                                                    <?php echo $row['faculty_name'] ?>
                                                </p>
                                            </td>
                                            <td class="">
                                                <p><small>
                                                        <?php echo $row['lec_day'] ?>
                                                    </small></p>
                                            </td>
                                            <td class="">
                                                <p><small>
                                                        <?php echo $row['subject_type'] ?>
                                                    </small></p>
                                            </td>
                                            <td class="">
                                                <p><small>
                                                        <?php echo $row['class_group'] ?>
                                                    </small></p>
                                            </td>
                                            <td class="">
                                                <p><small>
                                                        <?php echo $row['class'] ?>
                                                    </small></p>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary edit_timetable"
                                                    onclick="toggleUpdateButton()" data-id="<?php echo $row['id'] ?>"
                                                    type="button">Edit</button>
                                                <!-- <button class="btn btn-sm btn-outline-danger delete_course"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                type="button">Delete</button> -->
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
    <!-- </div> -->


    <!-- Modal -->
    <div class="modal fade timeModal" id="timeTableModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#356155;color:white;">
                    <h5 class="modal-title editTitle" id="exampleModalLabel">Add Subjects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="updateTimeTableBody">
                    <form action="" id="manage-timetable" class="editForm">
                        <div class="hiddenFiled">
                            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-sm-4">
                                <label for="s_code" class="form-label">Enter Subject code:</label>
                                <select class="form-control" name="s_code">
                                    <option selected disabled>----select subject code-----</option>
                                    <?php
                                    $student = $connection->query("SELECT subject_record.* FROM subject_record ORDER BY subject_type;");
                                    while ($row = $student->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row['subject_code'] ?>"><?php echo $row['subject_code'] . " " . " [" . $row['subject_type'] . " - " . $row['subject_name'] . " ]" ?>
                                        </option>
                                    <?php endwhile; ?>
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="s_name" class="form-label">Enter Subject Name:</label>
                                <select class="form-control" name="s_name">
                                    <option selected disabled>----select subject name-----</option>
                                    <?php
                                    $student = $connection->query("SELECT subject_record.* FROM subject_record ORDER BY subject_type;");
                                    while ($row = $student->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row['subject_name'] ?>"><?php echo "[ " . $row['subject_code'] . " - " . $row['subject_type'] . " ]" . "  " . $row['subject_name'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                    </option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="sel_teach" class="form-label">Select Subject Teacher</label>
                                <select class="form-control" name="sel_teach">
                                    <option selected disabled>----select teacher-----</option>
                                    <?php
                                    $student = $connection->query("SELECT * FROM teacher_record ORDER BY t_stream;");
                                    while ($row = $student->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row['t_name'] ?>"><?php echo $row['t_name'] . " " . "[ " . $row['t_stream'] . " ]" ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-sm-4">
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
                            <div class="col-sm-4">
                                <label for="sel_class" class="form-label">Select Class</label>
                                <select class="form-control" name="sel_class">
                                    <option selected disabled>----select class-----</option>
                                    <?php
                                    $student = $connection->query("SELECT * FROM student_record;");
                                    $uniqueStreams = array();
                                    while ($row = $student->fetch_assoc()):
                                        if (!in_array($row['class'], $uniqueStreams)):
                                            $uniqueStreams[] = $row['class'];
                                            ?>
                                            <option value="<?php echo $row['class'] ?>"><?php echo $row['class'] ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="sub_day" class="form-label">Enter Lecture Day:</label>
                                <select class="form-control" name="sub_day">
                                    <option selected disabled>----select Lecture Day----</option>
                                    <option>Monday</option>
                                    <option>Tuesday</option>
                                    <option>Wednesday</option>
                                    <option>Thursday</option>
                                    <option>Friday</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <div class="col-sm-4 mb-4">
                                <label for="start_time" class="form-label">Enter Lecture Start time:</label>
                                <input type="time" class="form-control" name="start_time" step="60" inputmode="numeric"
                                    data-time-format="hh:mm A">
                            </div>
                            <div class="col-sm-4 mb-4">
                                <label for="end_time" class="form-label">Enter Lecture End time:</label>
                                <input type="time" class="form-control" name="end_time" step="60" inputmode="numeric"
                                    data-time-format="hh:mm A">
                            </div>
                            <div class="col-sm-4 mb-4">
                                <label for="sub_type" class="form-label">Enter Lecture Type:</label>
                                <select class="form-control" name="sub_type">
                                    <option selected disabled>----select Lecture Type----</option>
                                    <option>Lecture</option>
                                    <option>Tute</option>
                                    <option>Lab</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-sm-4">
                                <label for="room_no" class="form-label">Enter Lecture room-no:</label>
                                <input type="text" class="form-control" name="room_no"
                                    value="<?php echo isset($room_no) ? $room_no : '' ?>">
                            </div>
                            <div class="col-sm-4">
                                <label for="sub_gp" class="form-label">Enter class Lecture Group:</label>
                                <select class="form-control" name="sub_gp">
                                    <option selected disabled>----select Lecture Group----</option>
                                    <option>G1</option>
                                    <option>G2</option>
                                    <option>Combine</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="close-button">Close</button>

                    <button type="button" style="display:block;background-color:#356155;color:white;" class="btn"
                        id='submit' onclick="$('.modal form').submit()">Save Timetable</button>

                    <button type="button" class="btn btn-primary" id='Update_btn'
                        style="display:none;background-color:#356155;color:white;">Update Timetable</button>
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
        $(document).ready(function () {
            $('#Update_btn').click(function () {
                $.ajax({
                    url: 'ajax2.php?action=update_timetable',
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
        $(document).ready(function () {
            $('.edit_timetable').click(function () {
                timeTableModal("Update Time-table Record's", "timetable_record.php?id=" + $(this).attr('data-id'));

            })
        });

        window.timeTableModal = function ($title = '', $url = '') {
            // alert($title)
            $.ajax({
                url: $url,
                error: function (xhr, status, error) {
                    console.error("Error in ajax request: " + error);
                    alert("An error occurred: " + error);
                },
                success: function (response) {
                    if (response) {
                        var $container = $(response).find('#updateTimeTableBody');
                        $('#timeTableModal .editTitle').html($title);
                        $('#timeTableModal .modal-body').html($container);
                        $('[id^="manage-timetable"]').prop('id', 'update-TimeTable');

                        $('#timeTableModal').modal({
                            show: true,
                            backdrop: 'static',
                            keyboard: false,
                            focus: true
                        });
                        $('#timeTableModal').modal('show');
                    }
                }
            })
        }
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
            $('#manage-timetable').submit(function (event) {
                event.preventDefault()

                $.ajax({
                    url: 'ajax2.php?action=manage-timetable',
                    data: new FormData(document.getElementById("manage-timetable")),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    success: function (data) {
                        alert('Timetable record added successfully');
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