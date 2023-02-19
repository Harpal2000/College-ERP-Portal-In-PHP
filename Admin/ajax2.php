<?php

require '../connection.php';

if (!$connection) {
    die("Failed to connect to the database: " . mysqli_connect_error());
}

$response = array();


if (isset($_GET["action"]) && $_GET["action"] == "manage_sub") {
    if (isset($_POST) && !empty($_POST)) {
        $sub_code = mysqli_real_escape_string($connection, $_POST['sub_code']);
        $sub_name = mysqli_real_escape_string($connection, $_POST['sub_name']);
        $sub_type = mysqli_real_escape_string($connection, $_POST['sub_type']);
        $s_stream = mysqli_real_escape_string($connection, $_POST['s_stream']);
        $sem = mysqli_real_escape_string($connection, $_POST['sem']);

        $sql = "INSERT INTO subject_record (subject_code,subject_name,subject_type,subject_stream,subject_sem) 
                VALUES ('$sub_code', '$sub_name','$sub_type', '$s_stream', '$sem')";

        if (mysqli_query($connection, $sql)) {
            $response["success"] = true;
            $response["message"] = "Record inserted successfully";
        } else {
            $response["success"] = false;
            $response["message"] = "Error inserting record";
        }
    }
}
if (isset($_GET["action"]) && $_GET["action"] == "update_sub") {
    if (isset($_POST) && !empty($_POST)) {
        $sub_code = mysqli_real_escape_string($connection, $_POST['sub_code']);
        $sub_name = mysqli_real_escape_string($connection, $_POST['sub_name']);
        $s_stream = mysqli_real_escape_string($connection, $_POST['s_stream']);
        $sem = mysqli_real_escape_string($connection, $_POST['sem']);

        $update_query = "UPDATE subject_record SET subject_name = '$sub_name', subject_stream = '$s_stream', subject_sem = '$sem' WHERE subject_code = '$sub_code'";

        if (mysqli_query($connection, $update_query)) {
            $response["success"] = true;
            $response["message"] = "Record inserted successfully";
        } else {
            $response["success"] = false;
            $response["message"] = "Error inserting record";
        }
    }
}

if (isset($_GET["action"]) && $_GET["action"] == "delete_subject") {
    if (isset($_POST["subject_code"]) && !empty($_POST["subject_code"])) {

        $subjectCode = $_POST["subject_code"];

        $delete_query = "DELETE FROM subject_record WHERE subject_code = '$subjectCode'";

        if (mysqli_query($connection, $delete_query)) {
            $response["success"] = true;
            $response["message"] = "Record deleted successfully";
        } else {
            $response["success"] = false;
            $response["message"] = "Error inserting record";
        }
    }
}


if (isset($_GET["action"]) && $_GET["action"] == "manage-timetable") {
    if (isset($_POST) && !empty($_POST)) {
        $s_code = mysqli_real_escape_string($connection, $_POST['s_code']);
        $s_name = mysqli_real_escape_string($connection, $_POST['s_name']);
        $sel_teach = mysqli_real_escape_string($connection, $_POST['sel_teach']);
        $sem = mysqli_real_escape_string($connection, $_POST['sem']);
        $sel_class = mysqli_real_escape_string($connection, $_POST['sel_class']);
        $sub_day = mysqli_real_escape_string($connection, $_POST['sub_day']);
        $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
        $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);
        $sub_type = mysqli_real_escape_string($connection, $_POST['sub_type']);
        $sub_gp = mysqli_real_escape_string($connection, $_POST['sub_gp']);
        $room_no = mysqli_real_escape_string($connection, $_POST['room_no']);


        // insert the data into the database
        $sql = "INSERT INTO timetable (`subject_code`, `subject_name`, `faculty_name`, `start_time`,`end_time`, `semester`, `lec_day`, `room_no`, `subject_type`,`class_group`, `class`) VALUES ('$s_code', '$s_name', '$sel_teach', '$start_time','$end_time', '$sem', '$sub_day', '$room_no', '$sub_type','$sub_gp', '$sel_class')";

        if (mysqli_query($connection, $sql)) {
            echo "Record inserted successfully";
        } else {
            echo "Error inserting record: " . mysqli_error($connection);
        }

        mysqli_close($connection);
    }
}


if (isset($_GET["action"]) && $_GET["action"] == "update_timetable") {
    if (isset($_POST) && !empty($_POST)) {
        $id = mysqli_real_escape_string($connection, $_POST['id']);
        $s_code = mysqli_real_escape_string($connection, $_POST['s_code']);
        $s_name = mysqli_real_escape_string($connection, $_POST['s_name']);
        $sel_teach = mysqli_real_escape_string($connection, $_POST['sel_teach']);
        $sem = mysqli_real_escape_string($connection, $_POST['sem']);
        $sel_class = mysqli_real_escape_string($connection, $_POST['sel_class']);
        $sub_day = mysqli_real_escape_string($connection, $_POST['sub_day']);
        $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
        $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);
        $sub_type = mysqli_real_escape_string($connection, $_POST['sub_type']);
        $sub_gp = mysqli_real_escape_string($connection, $_POST['sub_gp']);
        $room_no = mysqli_real_escape_string($connection, $_POST['room_no']);

        $update_query = "UPDATE timetable SET subject_code = '$s_code', subject_name = '$s_name', faculty_name = '$sel_teach', start_time = '$start_time', end_time = '$end_time', semester = '$sem', lec_day = '$sub_day', room_no = '$room_no', subject_type= '$sub_type', class_group = '$sub_gp', class = '$sel_class' WHERE id = '$id'";

        if (mysqli_query($connection, $update_query)) {
            $response["success"] = true;
            $response["message"] = "Record inserted successfully";
        } else {
            $response["success"] = false;
            $response["message"] = "Error inserting record";
        }
    }
}

?>