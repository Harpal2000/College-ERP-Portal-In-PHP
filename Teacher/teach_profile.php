<?php

require '../connection.php';

session_start();

if (!isset($_SESSION['LoginStudent'])) {
    header('Location:login.php');
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
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">

    <title>Teacher: Profile</title>

</head>
<style>
    body {
        background-color: rgb(226, 226, 226);

    }

    .fields {
        /* width: 40%; */

    }

    .fields input {
        background-color: #33736206;
        border: 0.7px solid #3373628c;
        height: 27px;
        border-radius: 4px;
        font-size: small;
        font-size: 15px;
    }

    .fields label {
        font-size: xx-small;
        color: #2D2D2D;
    }

    .studForm {
        background-color: white;
    }

    .academicHeading {
        background-color: #337362;
        color: white;
    }

    @media screen and (max-width:1193px) {
        .profession {
            font-size: 10px;
        }

    }

    @media screen and (max-width:1179px) {
        .stud-text {
            font-size: small;
        }

    }

    @media screen and (max-width:1056px) {
        .uniName {
            font-size: 12px;
        }

        .profession {
            font-size: 8px;
        }

        .nav-text {
            font-size: 14px;
        }

    }

    @media (max-width:1168px) and (min-width:1055px) {
        .profession {
            font-size: 11px;
        }
    }

    @media screen and (max-width:894px) {
        .uniName {
            font-size: 10px;
        }

        .profession {
            font-size: 6px;
        }

        .nav-text {
            font-size: 12px;
        }

        .menu-links .nav-link a .nav-text {
            display: none;

        }

        .menu-links .nav-link a i {
            margin-left: auto;
            margin-right: auto;

        }


    }

    @media screen and (max-width:576px) {
        .logo-text {
            display: none;
        }

        .logoImg {
            margin-left: auto;
            margin-right: auto;
        }

        .stud-text {
            display: none;
        }

        .stud-image {
            margin-left: auto;
            margin-right: auto;
        }

        .active-cont #menu-btn {
            /* background-color: red; */
            /* width: 20px; */
            height: 10px;
            margin-left: 30px;
        }
    }
</style>

<body>





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
            <a class="btn border-0 mt-0" id="menu-btn" style="height: 1%;">
                <i class="bx bx-menu"></i>
            </a>



            <?php
            $teacherName = $_GET['t_name'];
            $query = "select * from teacher_record where t_name = '$teacherName'";

            $result = mysqli_query($connection, $query);
            ?>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- main Content  -->

                    <div class="container ms-1 ps-3  ">
                        <div class="row d-flex mb-2 " style="margin-top:0px">
                            <div class="col ms-0" style="padding-left: 0;">
                                <div class="text" style="display:flex; flex-direction: column;color: black;font-size:26px">
                                    <b>YOUR PROFILE</b><span
                                        style="color: #570706 ;font-size:xx-small;margin-top: -10px;"><b>Welcome
                                            to your profile
                                            <?php echo "$teacherName"; ?>
                                        </b></span>
                                </div>
                            </div>

                        </div>

                        <!-- student content  -->
                        <div class="contianer stud-content" style="width:94%">


                            <div class="row studForm rounded pb-1 " style="">
                                <?php
                                $image = $data['t_image'];
                                if (!empty($image)) {
                                    $image_src = "teacher_profile/" . $image;
                                    ?>
                                    <div class="row border-3 ms-0"
                                        style="background-image: linear-gradient(0deg, white 0%, white 65%, rgb(226, 226, 226) 0%);">
                                        <img class="ms-0 ps-0" src="<?php echo $image_src; ?>" alt="T_image"
                                            style="width: 5.8rem; height: 5.4rem;">
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="row border-3 ms-0"
                                        style="background-image: linear-gradient(0deg, white 0%, white 65%, rgb(226, 226, 226) 0%);">
                                        <img class="ms-0 ps-0" src="teacher_profile/tumb.jpeg" alt="Thumbnail"
                                            style="width: 5.8rem; height: 5.4rem;">
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="row mt-1">
                                    <h6><b>
                                            <?php echo $data['t_name']; ?>
                                        </b></h6>
                                    <span class="pull-right">
                                        <a href="#edit" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#edit"></i>Edit-profile</a>
                                    </span>
                                </div>
                                <div class="row ">


                                    <form class="form-card justify-content-center" onsubmit="event.preventDefault()">
                                        <div class="row justify-content-between text-left my-1">
                                            <div class="form-group col-sm-6 flex-column d-flex  fields"> <label
                                                    class="form-control-label ">Address<span class="text-danger">
                                                    </span></label> <input type="text" id="address" name="lname"
                                                    value="<?php echo $data['t_address']; ?>" disabled readonly
                                                    class="text-dark" onblur="validate(2)"> </div>
                                            <div class="form-group col-sm-6 flex-column d-flex fields"> <label
                                                    class="form-control-label ">City<span class="text-danger">
                                                    </span></label> <input type="text" id="city" name="mob"
                                                    value=" <?php echo $data['t_address']; ?>" disabled readonly
                                                    class="text-dark" onblur="validate(4)"> </div>
                                        </div>
                                        <div class="row justify-content-between text-left my-1">
                                            <div class="form-group col-sm-6 flex-column d-flex fields"> <label
                                                    class="form-control-label ">E-mail<span class="text-danger">
                                                    </span></label> <input type="text" id="email" name="email"
                                                    value="<?php echo $data['t_email']; ?>" disabled readonly class="text-dark"
                                                    onblur="validate(3)"> </div>
                                            <div class="form-group col-sm-6 flex-column d-flex fields"> <label
                                                    class="form-control-label ">Phone number<span class="text-danger">
                                                    </span></label> <input type="text" id="phone" name="mob"
                                                    value="<?php echo $data['t_phone']; ?>" disabled readonly class="text-dark"
                                                    onblur="validate(4)"> </div>
                                        </div>
                                        <div class="row justify-content-between text-left my-1">
                                            <div class="form-group col-sm-6 flex-column d-flex fields"> <label
                                                    class="form-control-label ">Date Of Birth<span class="text-danger">
                                                    </span></label> <input type="text" id="dob" name="email"
                                                    value="<?php echo $data['t_dob']; ?>" disabled readonly class="text-dark"
                                                    onblur="validate(3)">
                                            </div>
                                            <div class="form-group col-sm-6 flex-column d-flex fields"> <label
                                                    class="form-control-label ">Your Hire Date<span class="text-danger">
                                                    </span></label> <input type="text" id="hDate" name="mob"
                                                    value="<?php echo $data['hire_date']; ?>" disabled readonly
                                                    class="text-dark" onblur="validate(4)"> </div>
                                        </div>
                                        <div class="row justify-content-between text-left my-1">
                                            <div class="form-group col-sm-6 flex-column d-flex fields"> <label
                                                    class="form-control-label ">Gender<span class="text-danger">
                                                    </span></label> <input type="text" id="gender" name="email"
                                                    value="<?php echo $data['t_gender']; ?>" disabled readonly class="text-dark"
                                                    onblur="validate(3)"> </div>
                                            <div class="form-group col-sm-6 flex-column d-flex fields pb-1"> <label
                                                    class="form-control-label ">Your Stream<span class="text-danger">
                                                    </span></label> <input type="text" id="stream" name="mob"
                                                    value="<?php echo $data['t_stream']; ?>" disabled readonly class="text-dark"
                                                    onblur="validate(4)"> </div>
                                        </div>



                                    </form>
                                </div>
                            </div>

                            <!-- academic content  -->

                            <!-- <div class="row align-items-center bg-light mt-2 rounded" style="">
                                <div class="row  academicHeading ms-0 rounded-top">Academic Details</div>
                                <div class="row justify-content-between text-left my-2">
                                    <div class="form-group col-sm-6 flex-column d-flex fields"> <label
                                            class="form-control-label ">Batch<span class="text-danger">
                                            </span></label> <input type="text" id="email" name="email"
                                            value=" <?php echo $data['s_batch']; ?>" disabled readonly class="text-dark"
                                            onblur="validate(3)"> </div>
                                    <div class="form-group col-sm-6 flex-column d-flex fields pb-1"> <label
                                            class="form-control-label ">University Roll No<span class="text-danger">
                                            </span></label> <input type="text" id="mob" name="mob"
                                            value=" <?php echo $data['roll_no']; ?>" disabled readonly class="text-dark"
                                            onblur="validate(4)"> </div>
                                </div>
                                <div class="row justify-content-between text-left mb-1">
                                    <div class="form-group col-sm-6 flex-column d-flex fields"> <label
                                            class="form-control-label ">Course-Branch<span class="text-danger">
                                            </span></label> <input type="text" id="email" name="email"
                                            value="<?php echo $data['class']; ?>" disabled readonly class="text-dark"
                                            onblur="validate(3)"> </div>
                                    <div class="form-group col-sm-6 flex-column d-flex fields pb-1"> <label
                                            class="form-control-label ">Regular/Leet<span class="text-danger">
                                            </span></label> <input type="text" id="mob" name="mob" value="Regular" disabled
                                            readonly class="text-dark" onblur="validate(4)">
                                    </div>
                                </div>
                            </div> -->
                            <?php include 'profile_modal.php'; ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo 'No Data Available';
            }

            ?>

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