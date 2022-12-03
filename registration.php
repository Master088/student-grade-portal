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

if (isset($_POST['submit'])) {

    $lrn = $_POST['lrn'];
    $fullname = $_POST['fullname'];
    $guardian_name = $_POST['guardian_name'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['confirm_password'];

    if ($password != $password2) {
        echo '<script>';
        echo "alert('password not macth!');";
        echo '</script>';
    } else {
        $date = date_create();
        $stamp = date_format($date, 'YmdHis');
        $temp = $_FILES['file']['tmp_name'];

        $directory = "upload/" . $stamp . $_FILES['file']['name'];

        if (move_uploaded_file($temp, $directory)) {

            $sql = "SELECT * FROM  account where lrn='$lrn'";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                echo '<script>';
                echo "alert('LRN already taken!');";
                echo '</script>';
            } else {

                $sql = "INSERT INTO account 
                    SET 
                    id=null,
                    lrn='$lrn',
                    fullname='$fullname',
                    gender='$gender',
                    guardian_name='$guardian_name',
                    -- account_type='student',                    
                    username='$username',
                    profile='$directory',
                    password='$password';
                    ";

                if (mysqli_query($conn, $sql)) {

                    echo '<script>';
                    echo "alert('Add Sucessfully!');";
                    echo '</script>';
                    header("Refresh:1; url=login.php", true, 1);
                } else {
                    echo mysqli_error($conn);
                    echo '<script>';
                    echo "alert('Error Occurfsfd!');";
                    echo '</script>';
                    header("Refresh:1; url=registration.php", true, 1);
                }
            }
        }
    }
} else {
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body {}
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet" />
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


<link rel="stylesheet" href="style.css">

<body>

    <div>
        <section class="text-center">

            <div class="p-5 bg-image" style="
                    background-image: url('img/background.png');
                    height: 300px;
                    "></div>


            <div class="card mx-4 mx-md-5 shadow-5-strong" style="
                    margin-top: -100px;
                    background: hsla(0, 0%, 100%, 0.8);
                    backdrop-filter: blur(30px);
                    ">
                <div class="card-body py-5 px-md-5">

                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8">
                            <h2 class="fw-bold mb-5">Register From</h2>
                            <form method="POST" action="" enctype="multipart/form-data">

                                <div>
                                    <div class="form">
                                        <img src="profile.png" class="border" alt="Profile" id="output" width="250">
                                        <input accept="image/*" onchange="loadFile(event)" type="file" name="file" required>
                                    </div>
                                </div>
                                <div class=" mb-4">
                                    <div class="form">
                                        <label class="form-label" for="lrn">LRN</label>
                                        <input type="text" name="lrn" id="lrn" class="form-control" />

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form">
                                            <label class="form-label" for="fullname">Fullname</label>
                                            <input type="text" id="fullname" name="fullname" class="form-control" />

                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" for="gender">Gender</label>
                                        <select class="form-select" name="gender" required aria-label="Default select example">
                                            <option selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form mb-4 ">
                                    <label class="form-label" for="guardian_name">Guardian Name</label>
                                    <input type="text" name="guardian_name" id="guardian_name" class="form-control" />

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" name="username" class="form-control" />

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form">
                                            <label class="form-label" for="pasword">Password</label>
                                            <input type="password" id="pasword" name="password" class="form-control" />

                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form">
                                        <label class="form-label" for="confirm_password">Confirm Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" />

                                    </div>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" name="submit" class="btn btn-primary btn-block mb-2">
                                    Register
                                </button>
                                <button type="reset" class="btn btn-danger btn-block mb-5">
                                    Reset
                                </button>
                                <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? <a href="login.php" style="color: #393f81;">Login Here.</a></p>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.setAttribute("class", "out");
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>