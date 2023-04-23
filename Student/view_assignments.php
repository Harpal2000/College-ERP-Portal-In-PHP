<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginStudent'])) {
    header('Location:login.php');
}

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


$query2 = "SELECT * FROM timetable WHERE lec_day = 'monday' AND class = '$Student_class' AND class_group = '$Student_group' OR (lec_sch = 'combine' AND lec_day = 'monday' AND class = '$Student_class')";


$result2 = mysqli_query($connection, $query2);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard: View Assignments</title>
    <link rel="stylesheet" href="/extra/nav.css">
    <link rel="stylesheet" href="/bootstrap/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text&display=swap" rel="stylesheet">

    <style>
        body {

            background-color: rgb(226, 226, 226);
        }
    </style>
</head>

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
                    <a href="#">
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
                            <b>ACADEMIC CONTENT</b><span
                                style="color: #570706 ;font-size:xx-small;margin-top: -10px;"><b>VIEW AND DOWNLOAD YOUR
                                    ACADEMIC CONTENT</b></span>
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

                    <div
                        class="attendance-head headings text-light ps-2 rounded-top p-2 d-flex justify-content-between">

                        <div>Rollno:
                            <?php echo $stu_roll_no; ?>
                        </div>
                        <div class="pe-2">Section:
                            <?php echo $Student_class . "( " . $Student_group . " )"; ?>
                        </div>

                    </div>

                    <table class="tabl table table-sm table-hover bg-light rounded-bottom text-center" cellpadding="9">
                        <thead>
                            <tr>
                                <th scope="col">S. No.</th>
                                <th scope="col">Subject Name</th>
                                <th scope="col">A1</th>
                                <th scope="col">A2</th>
                            </tr>
                        </thead>
                        <tbody class="px-5">
                            <?php
                            $i = 1;
                            if (mysqli_num_rows($result2) > 0) {
                                while ($data2 = mysqli_fetch_assoc($result2)) {
                                    $subject_name = $data2['subject_name'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i++ ?>
                                        </td>
                                        <td>
                                            <?php echo $data2['subject_name'] . ' [ ' . $data2['subject_code'] . ']' ?>
                                        </td>

                                        <?php
                                        $Query = "SELECT * FROM assignment_record WHERE class = '$Student_class' AND subject_name = '$subject_name'";
                                        $assign_result = mysqli_query($connection, $Query);

                                        if (mysqli_num_rows($assign_result) > 0) {
                                            $found_assignments = array(0, 0);

                                            while ($data = mysqli_fetch_assoc($assign_result)) {
                                                if ($data['assign_no'] == 1) {
                                                    $found_assignments[0] = 1;
                                                    echo "<td><a href='../Teacher/assignment_data/{$data['assign_file']}'>Assignment-1</a></td>";
                                                } elseif ($data['assign_no'] == 2) {
                                                    $found_assignments[1] = 1;
                                                    echo "<td><a href='../Teacher/assignment_data/{$data['assign_file']}'>Assignment-2</a></td>";
                                                }
                                            }

                                            if (!$found_assignments[0]) {
                                                echo "<td style='color:red;'>No record found!</td>";
                                            }
                                            if (!$found_assignments[1]) {
                                                echo "<td style='color:red;'>No record found!</td>";
                                            }
                                        } else {
                                            echo "<td style='color:red;'>No record found!</td><td style='color:red;'>No record found!</td>";
                                        }
                                        ?>





                                    <?php }
                            } ?>
                        </tbody>




                    </table>

                </div>



            </div>

        </div>
    </div>

















    <!-- pala da code  -->





    <script>
        var menu_btn = document.querySelector("#menu-btn");
        var sidebar = document.querySelector("#sidebar");
        var container = document.querySelector(".my-container");
        menu_btn.addEventListener("click", () => {
            sidebar.classList.toggle("active-nav");
            container.classList.toggle("active-cont");
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>