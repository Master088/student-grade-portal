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


    //////////

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
            $_SESSION['status_error'] = "error";
        }
    } else {
        /// for student encryption
        $ciphering = "AES-128-CTR";
        $option = 0;
        $encryption_iv = '1234567890123456';
        $encryption_key = "info";
        $encryption_pass = openssl_encrypt($password, $ciphering, $encryption_key, $option, $encryption_iv);
        $sql = "SELECT * FROM student
        WHERE username = '$username'
        AND password = '$encryption_pass'";

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
            $_SESSION['status'] = "error";
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
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
        /* background-image: url("img/background.png"); */
        height: 100%;
        font-size: 1em;
        overflow-x: hidden;
        overflow-y: visible;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: #F8FAFB;
    }

    .bg-glass {
        background-color: hsla(0, 0%, 100%, 0.9) !important;
        backdrop-filter: saturate(200%) blur(25px);
    }
</style>

<body>

    <div>

        <!-- <div class="container py-5 h-100">
            
            <div class="row d-flex justify-content-end align-items-end h-100">
                <div class="col-md-8 col-lg-7 col-xl-6 ">
                    <img src="img/undraw_remotely_2j6y.svg"
                    class="img-fluid" alt="Phone image">
                </div>
                <div class="col col-md-5  ">
                    <div class="card bg-glass" style="border-radius: 1rem;">
                        <div class="row g-0">

                            <div class="col-md-12 d-flex align-items-center">
                                <div class="card-body p-4 text-black">

                                    <form method="POST" class="needs-validation" novalidate>

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Logo</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login your account here.</h5>

                                        <div class="form mb-4">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" name="username" class="form-control form-control-lg" required>
                                            <div class="invalid-feedback">Please Enter Username.</div>
                                        </div>

                                        <div class="form mb-4">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                                            <div class="invalid-feedback">Please Enter Password.</div>

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
        </div> -->

        <section>
            <div class="container py-5 h-100">
                <div class="row gx-lg-5 align-items-center mb-5">
                    <div class="col-md-8 col-lg-7 col-xl-6">
                        <img src="img/undraw_remotely_2j6y.svg" class="img-fluid" alt="Phone image">
                    </div>

                    <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                        <div class="card bg-glass">
                            <div class="card-body px-2 py-3 px-md-3">
                                <form method="POST" class="needs-validation" novalidate>
                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                        <span class="h1 fw-bold mb-0">
                                            <h5 class="fw-normal mt-1" style="letter-spacing: 1px;">Ocean of Knowledge Ementary School.</h5>
                                        </span>
                                    </div>

                                    <div class="form mb-4 mt-5">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" id="username" name="username" class="form-control form-control-lg" required>
                                        <div class="invalid-feedback">Please Enter Username.</div>
                                    </div>

                                    <div class="form mb-4">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                                        <div class="invalid-feedback">Please Enter Password.</div>

                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input me-2" type="checkbox" value="yes" name="isTeacher" id="isTeacher" />
                                        <label class="form-check-label" for="isTeacher">
                                            Are you a teacher?
                                        </label>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-lg btn-block text-white" type="submit" name="submit" style="background-color: #6C63FF; ">Login</button>
                                    </div>


                                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="registration.php" style="color: #393f81;">Register Here.</a></p>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>





    <script type="text/javascript" src="js/main.js"></script>
</body>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
<script src="js/sweetalert2.js"></script>
<?php
if (isset($_SESSION['status_error']) && $_SESSION['status_error'] != '') {
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',

        })
    </script>
<?php
    unset($_SESSION['status_error']);
}
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'error',
            title: 'Login Field!'
        })
    </script>
<?php
    unset($_SESSION['status']);
}
?>

</html>