<?php

require '../connection.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Teacher's Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
    <br>
    <div class="container-fluid">
        <a href="admin-index.php"><button type="button" class="btn btn-secondary btn-sm">Main Dashboard</button></a>
        <a href="teacher_register.php"><button type="button" class="btn btn-secondary btn-sm">Teacher
                Register</button></a>
    </div>
    <div id="records">

        <center>
            <div id="tableDiv" style="width:80%">
                <h1>Teacher's Records</h1>
                <hr>
                <br>
                <?php
                $query = "SELECT * FROM teacher_record";

                $result = mysqli_query($connection, $query);

                ?>


                <?php
                $query2 = "select * from login where role='Student' or role='teacher'";

                $result2 = mysqli_query($connection, $query2);

                if ($result2 && mysqli_num_rows($result2) > 0) {
                    while ($data2 = mysqli_fetch_assoc($result2)) {
                        $Student_status = $data2['account'];
                        $Student_username = $data2['username'];
                    }
                } else {
                    echo 'No Data Available';
                }

                ?>

                <table id="myTable" class="display table-condensed table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id_No</th>
                            <th>Teacher Name / Stream</th>
                            <th>Teacher Password</th>
                            <th>Information</th>
                            <th>Contact No.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr align='center'>
                                    <td>
                                        <?php echo $data['t_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['t_name'] . " " . "(" . $data['t_stream'] . " )"; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['t_pass']; ?>
                                    </td>
                                    <td>
                                        <small><b>Email: </b><i>
                                                <?php echo $data['t_email']; ?>
                                            </i></small><br>
                                        <small><b>Hire-Date: </b><i>
                                                <?php echo $data['hire_date']; ?>
                                            </i> </small>
                                        <small><b>Address: </b><i>
                                                <?php echo $data['t_address']; ?>
                                            </i></small>
                                    </td>
                                    <td>
                                        <?php echo $data['t_phone']; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary edit_course" type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit-<?php echo $data['t_id']; ?>">Edit</button>

                                        <button class="btn btn-sm btn-outline-danger delete_course"
                                            type="button">Delete</button>
                                    </td>
                                </tr>
                                <?php include 'update_teach.php'; ?>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <br>
        </center>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });

        $(document).ready(function () {
            $(".edit_course").click(function () {
                var t_id = $(this).closest("tr").find("td:first-child").text();
                var t_name = $(this).closest("tr").find("td:nth-child(2)").text();
                var t_phone = $(this).closest("tr").find("td:nth-child(5)").text();
                var t_email = $(this).closest("tr").find("td:nth-child(4) i:first-child").text();
                var t_address = $(this).closest("tr").find("td:nth-child(4) i:last-child").text();

                $("#edit-" + t_id + " #nameE").val(t_name);
                $("#edit-" + t_id + " #phoneE").val(t_phone);
                $("#edit-" + t_id + " #emailE").val(t_email);
                $("#edit-" + t_id + " #addressE").val(t_address);
            });
        });
    </script>


</body>

</html>