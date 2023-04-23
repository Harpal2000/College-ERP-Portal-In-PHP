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
    <title>Dashboard: Teacher</title>
    <link rel="stylesheet" href="/extra/nav.css">
    <link rel="stylesheet" href="/bootstrap/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text&display=swap" rel="stylesheet">


</head>
<style>
    body {
        background-color: rgb(226, 226, 226);
    }
</style>

<body>




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
                <div class="stud-text text text-center "
                    style="font-weight: 100; text-align: center; margin-left: 10px;">
                    <span class="text-center ps-5">
                        <?php echo $_SESSION['LoginTeacher']; ?>
                    </span> </a>
                </div>


            </div>


            <ul class="menu-links " style="padding-left: 0;">
                <li class="nav-link">
                    <a href="../teacher/teacher-index.php" class="mx-auto" style="">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text ">Dashboard</span>

                    </a>
                </li>
                <li class="nav-link">
                    <a href="student_att.php?t_name=<?php echo $_SESSION['LoginTeacher']; ?>" class="mx-auto" style="">
                        <i class='bx bx-calendar-check icon'></i>
                        <span class="text nav-text ">Attendance</span>

                    </a>
                </li>

                <li class="nav-link">
                    <a href="upload_assignments.php?t_name=<?php echo $_SESSION['LoginTeacher']; ?>">
                        <i class='bx bx-bar-chart-alt-2 icon'></i>
                        <span class="text nav-text">Upload Assignments</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="stu_internal_mark.php?t_name=<?php echo $_SESSION['LoginTeacher']; ?>">
                        <i class='bx bx-pie-chart-alt icon'></i>
                        <span class="text nav-text">Upload Marks</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="teach_profile.php?t_name=<?php echo $_SESSION['LoginTeacher']; ?>">
                        <i class='bx bx-pie-chart-alt icon'></i>
                        <span class="text nav-text">Profile</span>
                    </a>
                </li>


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
                            <b>DASHBOARD</b><span
                                style="color: #570706 ;font-size:xx-small;margin-top: -10px;"><b>Welcome back
                                    <?php echo $_SESSION['LoginTeacher']; ?>
                                </b></span>
                        </div>
                    </div>
                </div>


                <div class="row attendance-table ">

                    <?php
                    $teacher_name = $_SESSION['LoginTeacher'];
                    $query = "SELECT * FROM `timetable` WHERE faculty_name = '$teacher_name'";

                    $result = mysqli_query($connection, $query);

                    ?>
                    <div class="attendance-head headings text-light ps-2 rounded-top p-2 d-flex justify-content-center">
                        <div>Your Time Table
                        </div>
                    </div>

                    <table class="tabl table table-sm table-hover bg-light rounded-bottom text-center">
                        <thead>
                            <tr>
                                <th scope="col">S.No.</th>
                                <th scope="col">Subject Code</th>
                                <th scope="col">Subject Name</th>
                                <th scope="col">Time Slot</th>
                                <th scope="col">Day</th>
                                <th scope="col">Room No.</th>
                                <th scope="col">Subject Type</th>
                                <th scope="col">Class</th>
                            </tr>
                        </thead>
                        <tbody class="px-5">
                            <?php
                            $sr_no = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($data = mysqli_fetch_assoc($result)) {
                                    ?>

                                    <tr>
                                        <th>
                                            <?php echo $sr_no; ?>
                                        </th>
                                        <?php $sr_no = $sr_no + 1 ?>
                                        <td>
                                            <?php echo $data['subject_code']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['subject_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['start_time'] . " - " . $data['end_time']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['lec_day']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['room_no']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['subject_type']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['class']; ?>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            } else {
                                echo "No Data Found!";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>



            </div>

        </div>
    </div>
















    <!-- pala wala code  -->

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