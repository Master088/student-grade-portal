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
    <!-- <link rel="stylesheet" type="text/css" href="style1.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>
</head>
<style>
    * {
        box-sizing: border-box;
    }

    html,
    body {
        padding: 0;
        margin: 0;
        font-family: Poppins;
        font-weight: 300;
        background-image: url("img/background.png");
        height: 100%;
        font-size: 1em;
        overflow-x: hidden;
        overflow-y: visible;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

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

    <div>

        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-5  ">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">

                            <div class="col-md-12 d-flex align-items-center">
                                <div class="card-body p-4 text-black">

                                    <form method="POST">

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Logo</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login your account here.</h5>

                                        <div class="form mb-4">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" name="username" class="form-control form-control-lg" required>

                                        </div>

                                        <div class="form mb-4">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control form-control-lg" required>

                                        </div>
                                        <div class="form-check mb-4">
                                            <input class="form-check-input me-2" type="checkbox" value="yes" name="isTeacher" id="isTeacher" />
                                            <label class="form-check-label" for="isTeacher">
                                                Are you a teacher?
                                            </label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block " type="submit" name="submit">Login</button>
                                        </div>


                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="registration.php" style="color: #393f81;">Register Here.</a></p>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>





    <script type="text/javascript" src="js/main.js"></script>
</body>

</html>