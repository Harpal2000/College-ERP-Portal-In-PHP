<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginStudent'])) {
    header('Location:../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/extra/nav.css">
    <link rel="stylesheet" href="/bootstrap/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text&display=swap" rel="stylesheet">

    <title>Dashboard: Student</title>
    <style>
      body{
        background-color: rgb(226, 226, 226);
      }
    </style>
</head>

<body>
    <!-- <a href="../login.php"><button type="button">Main Page</button></a>
    <a href="pay_fee.php"><button type="button">Pay Fee</button></a>
    <a href="stuProfile.php"><button type="button">Profile</button></a>
    <a href="internal_marks.php"><button type="button">Internal Marks</button></a>
    <a href="view_assignments.php"><button type="button">View Assignments</button></a> -->



    <!-- div margin for margin the navbar     -->
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
                    <a href="../login.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    <!-- toogle icon  -->
    <div class="ps-lg-5 ps-md-4  pt-0 my-container active-cont" style="display: flex;">
        <a class="btn border-0 mt-2" id="menu-btn" style="height: 1%;">
            <i class="bx bx-menu"></i>
        </a>


        <!-- main Content  -->

        <div class="container ms-3  align-items-center" style="width: 90%;">
            <div class="row d-flex mb-5" style="margin-top:5px">
                <div class="col ms-0" style="padding-left: 0;">
                    <div class="text" style="display:flex; flex-direction: column;color: black;font-size:26px">
                        <b>DASHBOARD</b><span style="color: #570706 ;font-size:xx-small;margin-top: -10px;"><b>Welcome
                                to your dashboard</b></span>
                    </div>
                </div>
            </div>


            <div class="row attendance-table ">

                <?php
                $stu_roll_no = $_SESSION['LoginStudent'];
                $query = "select * from student_record where roll_no = $stu_roll_no";

                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($data = mysqli_fetch_assoc($result)) {
                        $Student_name = $data['s_name'];
                        $Student_class = $data['class'];
                        $Student_group = $data['s_group'];
                    }

                } else {
                    echo 'No Data Available';
                }

                ?>


                <?php
                $query2 = "SELECT * FROM timetable WHERE lec_day = 'monday' AND class = '$Student_class' AND class_group = '$Student_group' OR (lec_sch = 'combine' AND lec_day = 'monday' AND class = '$Student_class')";


                $result2 = mysqli_query($connection, $query2);

                ?>
                <?php
                date_default_timezone_set('Asia/Kolkata');
                $current_date = date("d-m-Y");
                ?>
                <div class="attendance-head headings text-light ps-2 rounded-top p-2 d-flex justify-content-between">
                    <div>Date:
                        <?php echo $current_date ?>

                    </div>
                    <div>Rollno:
                        <?php echo $stu_roll_no; ?>
                    </div>
                    <div class="pe-2">Section:
                        <?php echo $Student_class . "( " . $Student_group . " )"; ?>
                    </div>

                </div>

                <table class="tabl table table-sm table-hover bg-light rounded-bottom text-center">
                    <thead>
                        <tr>
                            <th scope="col">Lect No.</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Time Slot</th>
                            <th scope="col">Attendance</th>
                            <th scope="col">Ratio</th>
                            <th scope="col">Attendance %</th>
                        </tr>
                    </thead>
                    <tbody class="px-5">
                        <?php
                        $i = 1;
                        if (mysqli_num_rows($result2) > 0) {
                            while ($data2 = mysqli_fetch_assoc($result2)) {
                                ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $i++ ?>
                                    </th>
                                    <td style="text-align:start;">
                                        <?php echo $data2['subject_name'] . ' [ ' . $data2['subject_code'] . ']' . '<br>' ?>
                                        <p class="text-secondary" style="text-align:start;">
                                            <?php echo $data2['faculty_name'] ?>
                                        </p>
                                    </td>
                                    <td>
                                        <?php echo $data2['start_time'] . " - " . $data2['end_time']; ?>
                                    </td>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <?php
                                        $sub_id = $data2['id'];
                                        $current_date = date("Y-m-d");
                                        $query_att = "select * from attendance_record where sub_id = '$sub_id' and stu_roll_no = '$stu_roll_no' and att_date = '$current_date'";

                                        $result_att = mysqli_query($connection, $query_att);

                                        $total_present = 0;
                                        if (mysqli_num_rows($result_att) > 0) {
                                            while ($data2 = mysqli_fetch_assoc($result_att)) {
                                                if ($data2['att_status'] == '') {
                                                    ?>
                                                    <div class="na">
                                                        <?php echo 'N/A'; ?>
                                                    </div>
                                                    <?php
                                                } else if ($data2['att_status'] == 'Absent' or $data2['att_status'] == 'Present') {
                                                    if ($data2['att_status'] == 'Present') {
                                                        ?>
                                                            <button type="button" class="btn btn-success btn-sm" style="padding:2px;">
                                                            <?php echo $data2['att_status']; ?>
                                                            </button>
                                                        <?php
                                                    } else {
                                                        ?>
                                                            <button type="button" class="btn btn-danger btn-sm" style="padding:2px;">
                                                            <?php echo $data2['att_status']; ?>
                                                            </button>
                                                        <?php
                                                    }

                                                } else {
                                                    echo 'No Data Found';
                                                }
                                            }
                                        } else {
                                            ?>
                                            <div class="na">
                                                <?php echo 'N/A' ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $query_lec = "SELECT MAX(lec_no) AS max_lec FROM attendance_record WHERE sub_id = '$sub_id' AND stu_roll_no = '$stu_roll_no'";
                                        $result_lec = mysqli_query($connection, $query_lec);
                                        if (mysqli_num_rows($result_lec) >= 0) {
                                            while ($data2 = mysqli_fetch_assoc($result_lec)) {

                                                $delivered_lec = $data2['max_lec'];

                                                $query_count_att = "SELECT COUNT(*) AS count_att FROM attendance_record WHERE stu_name = '$Student_name' AND att_status = 'present' and sub_id = '$sub_id'";
                                                $result_count_att = mysqli_query($connection, $query_count_att);
                                                $data_count_att = mysqli_fetch_assoc($result_count_att);
                                                $total_present = $data_count_att['count_att'];

                                                if ($delivered_lec > 0) {
                                                    echo "$total_present" . "/" . "$delivered_lec";
                                                } else {
                                                    ?>
                                                    <div class="na">
                                                        <?php echo 'N/A' ?>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <div class="na">
                                                <?php echo 'N/A' ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($delivered_lec == 0) {
                                            echo "0%";
                                        } else {
                                            $attendance_percentage = ($total_present / $delivered_lec) * 100;
                                            echo number_format($attendance_percentage, 2) . "%";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }

                        } else {
                            echo 'No Data Available';
                        }
                        ?>
                    </tbody>
                </table>
            </div>



        </div>

    </div>
    </div>













</body>
<script>
    var menu_btn = document.querySelector("#menu-btn");
    var sidebar = document.querySelector("#sidebar");
    var container = document.querySelector(".my-container");
    menu_btn.addEventListener("click", () => {
        sidebar.classList.toggle("active-nav");
        container.classList.toggle("active-cont");
    });
</script>

</html>