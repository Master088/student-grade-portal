<?php

session_start();
include 'mysql_connect.php';


if (isset($_SESSION['isLogin'])) {
    if ($_SESSION['isLogin']) {
        if ($_SESSION['account_type'] == "teacher") {
            header('Location:index.php');
        } else {
            header('Location:studentDashboard.php');
        }
    }
}


// fires when login button click for teacher
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['isLogin'] = false;
    $sql = "";
    //teacher
    if (isset($_POST['isTeacher'])) {

        $sql = "SELECT * FROM teacher
        WHERE username = '$username'
        AND password = '$password'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) == 1) {

            $row = mysqli_fetch_assoc($res);

            $_SESSION['id'] = $row['teacher_id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['account_type'] = "teacher";
            $_SESSION['isLogin'] = true;

            echo '<script>';
            echo 'alert("success!")';
            echo '</script>';
            header("location:index.php");
        } else {
            echo '<script>';
            echo 'alert("Incorrect username or password!")';
            echo '</script>';
        }
    } else {
        $sql = "SELECT * FROM student
        WHERE username = '$username'
        AND password = '$password'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) == 1) {

            $row = mysqli_fetch_assoc($res);

            $_SESSION['lrn'] = $row['lrn'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['account_type'] = "student";
            $_SESSION['isLogin'] = true;

            echo '<script>';
            echo 'alert("success!")';
            echo '</script>';

            header("location:studentDashboard.php");
        } else {
            echo '<script>';
            echo 'alert("Incorrect username or password!")';
            echo '</script>';
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style>
    .login-content p {
        width: 700px;
        line-height: 26px;
        font-size: 18px;
        text-align: justify;
    }

    .logo {
        width: 200px;
    }
</style>

<body>

    <div class="  d-flex justify-content-center ">
        <form method="POST">
            <div class="login-content ">
                <img class="logo" src="img/avatar.svg">
                <h2 class="title">Welcome</h2>

                <div class="py-1">
                    <div class="d-flex">
                        <i class="fas fa-user fa-lg"></i>
                        <h5>Username</h5>
                    </div>
                    <div class="mt-1">
                        <input type="text" id="username" name="username" class="input" required>
                    </div>
                </div>

                <div class="py-1">
                    <div class="d-flex">
                        <i class="fas fa-lock fa-lg"></i>
                        <h5>Password</h5>
                    </div>
                    <div class="mt-1">
                        <input type="password" name="password" id="password" class="input" required>
                    </div>
                </div>
                <div class="py-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="yes" name="isTeacher" id="isTeacher">
                        <label class="form-check-label" for="flexCheckChecked">
                            Are you teacher?
                        </label>
                    </div>
                </div>
                <a href="registration.php">Register an account.</a>

                <div class="py-2">
                    <button type="submit" name="submit" class="btn btn-primary"> Login</button>
                </div>


            </div>
        </form>

    </div>

    <script type="text/javascript" src="js/main.js"></script>

</body>

</html>