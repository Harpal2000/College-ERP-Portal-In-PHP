<?php

require '../connection.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
</head>

<body>
<a href="admin-index.php"><button type="button">Dashboard</button></a><br><br>
    <center>
        <div id="regForm">
            <h1>Teacher Register Here</h1>



            
            <form action="" method="POST">
                <table cellpadding='10'>
                <tr>
                        <td>Teacher Id:</td>
                        <td><input type="text" name="t_id" id="t_id"></td>
                    
                        <td>Teacher Username:</td>
                        <td><input type="text" name="t_username" id="t_username"></td>
                    </tr>
                    <tr>
                        <td>Teacher E-mail:</td>
                        <td><input type="email" name="t_email" id="t_email"></td>
                    
                        <td>Teacher Password:</td>
                        <td><input type="password" name="t_password" id="t_password"></td>
                    </tr>
                    <tr>
                        <td>Teacher Mobile-no:</td>
                        <td><input type="text" name="t_phone" id="t_phone" maxlength="10"></td>
                        
                        <td>Teacher Your Stream:</td>
                        <td><input type="text" name="t_stream" id="t_stream"></td>
                    </tr>
                    <tr>
                        <td>Teacher D.O.B:</td>
                        <td><input type="text" name="t_dob" id="t_dob"></td>

                        <td>Teacher Address:</td>
                        <td><input type="text" name="t_addr" id="t_addr"></td>
                    </tr>
                    <tr>
                    <td>Enter Gender:</td>
                        <td>
                            <input type="radio" name="gender" value='Female'>Female
                            <input type="radio" name="gender" value='Male'>Male
                        </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <input type="submit" name="t-btn" id="t-btn" value="Register">
                        </td>
                    </tr>
            </form>
        </div>
    </center>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['t-btn'])){
    $t_username = $_POST['t_username'];
    $t_password = $_POST['t_password'];
    $t_email = $_POST['t_email'];
    $t_phone = $_POST['t_phone'];
    $t_stream = $_POST['t_stream'];
    $t_id = $_POST['t_id'];
    $t_dob = $_POST['t_dob'];
    $t_addr = $_POST['t_addr'];
    $gender = $_POST['gender'];

    $t_role = 'Teacher';
    $acc_status = 'Active';

    $current_date = date("Y-m-d");

    

    $Query = "INSERT INTO `teacher_record` (`t_id`,`t_name`, `t_email`, `t_pass`, `t_phone`,`t_gender`, `t_stream`,`hire_date`,`t_dob`,`t_address`) VALUES ('$t_id','$t_username','$t_email','$t_password','$t_phone','$gender','$t_stream','$current_date','$t_dob','$t_addr');";
    $Query .= "INSERT INTO `login` (`id`, `username`, `password`, `role`, `account`) VALUES ('$t_id','$t_username','$t_password','$t_role','$acc_status');";

    if($connection->multi_query($Query) === TRUE){
        echo "<script>
        alert('Register Successfully');
        window.location = 'teacher_register.php';
        </script>";

    }else{
        echo "Error: ". $Query . "<br>" . mysqli_error($Connection);
    }
}

?>
</body>

</html>
