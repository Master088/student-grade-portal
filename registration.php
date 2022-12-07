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


    // password ecryption for student
    $ciphering = "AES-128-CTR";
    $option = 0;
    $encryption_iv = '1234567890123456';
    $encryption_key = "info";
    $encryption_pass = openssl_encrypt($password,$ciphering,$encryption_key,$option,$encryption_iv);

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

            $sql = "SELECT * FROM  student where lrn='$lrn'";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                echo '<script>';
                echo "alert('LRN already taken!');";
                echo '</script>';
            } else {

                $sql = "INSERT INTO student 
                    SET 
                    id=null,
                    lrn='$lrn',
                    fullname='$fullname',
                    gender='$gender',
                    guardian_name='$guardian_name',
                    -- account_type='student',                    
                    username='$username',
                    profile='$directory',
                    password='$encryption_pass';
                    ";

                if (mysqli_query($conn, $sql)) {

                    // echo '<script>';
                    // echo "alert('Add Sucessfully!');";
                    // echo '</script>';
                    $_SESSION['status_success'] = "success";
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


<!-- <link rel="stylesheet" href="style.css"> -->
<style>
    body {
        font-family: Poppins;
        padding: 0;
        margin: 0;
      
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
    .form-label{
        color:grey;
        justify-content: start;
        display: flex;
    }
    .btn-submit{
        
        justify-content: start;
        display: flex;
    }
    .file-upload{
        display: inline-block;
        padding: 0 10px;
        height: 36px;
        line-height: 36px;
        color: white;
        background-color: #6C63FF;
        cursor: pointer;
        border-radius: 5px;
    }
    .file-upload input[type="file"]{
        display: none;
    
    }
    label{
        cursor: pointer;
    }
    .profile-img {
        border-radius: 10%;
        height: 28vh;
        width: auto;
    }
    #output{
        border-radius: 10%;
        min-height: 28vh;
        min-width: 15vw;
        object-fit: fill;
    }
    
</style>
<body>

<div class="container-fluid">
        <div class="row">
            <div class=" col-6 pt-5 text-center d-none d-lg-block">
                <h3 class="text-center">Registration Form</h3>
                <div class="image_section img-responsive pt-5 px-5 ">
                    <div class="px-5">
                    <img src="img/logo-registration.svg" alt="" style="width: 32rem;" class="pt-5  img-fluid  ">
                    </div>
                </div>
            </div>
            <div class="col pt-3 mb-4">
                <div class="card shadow p-3 card-registration" style="border-radius: 15px;">
                    <div class="card-body">
                     
                     <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 text-center">   
                                    <img src="img/profile_icon.svg" class="border profile-img " alt="Profile" id="output" width="150" height="150">                          
                                    <div class="box pt-3 px-3">
                                        <div class="file-upload "> 
                                            <input type="file" class="form-control" id="upload" accept="image/*" onchange="loadFile(event)" name="file" required/>
                                            <label for="upload">Upload Image</label>
                                            <!-- choose file -->
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-8 col-sm-12 mb-4 pt-5 px-5">
                                        <label class="form-label" for="lrn">LRN</label>
                                        <input type="text" name="lrn" id="lrn" class="form-control" required/>
                                </div>
                            </div>
                        <div class="row pt-2">
                            <div class="col-md-6 mb-3">
                                <div class="form">
                                    <label class="form-label" for="fullname">Fullname</label>
                                    <input type="text" id="fullname" name="fullname" class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" required>
                                <label class="form-label" for="gender">Gender</label>
                                <select class="form-select" name="gender" aria-label="Default select example" required>
                                    <option selected value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form mb-3 ">
                                    <label class="form-label" for="guardian_name">Guardian Name</label>
                                    <input type="text" name="guardian_name" id="guardian_name" class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" id="username" name="username" class="form-control" required/>
        
                                </div>
                            </div>
                    </div>

                    <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form">
                                    <label class="form-label" for="pasword">Password</label>
                                    <input type="password" id="pasword" name="password" class="form-control" required/>
        
                                </div>
                            </div>
                       
                        <div class="col-md-6 mb-3">
                            <div class="form">
                                <label class="form-label" for="confirm_password">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required/>
        
                            </div>
                        </div>
                    </div>
        
                        
                        <div class="btn-submit mt-4">
                            <button type="submit" name="submit" class="btn btn-primary mb-3" style="background-color: #6C63FF;">
                                <i class="bi bi-send-plus-fill"></i> Register
                            </button>
                            <button type="reset" class="btn btn-danger mb-3" style="margin-left: 1vw;">
                                <i class="bi bi-x-octagon-fill"></i> Reset
                            </button>
                            
                        </div> 
                        <p class="mb-2 pb-lg-2" style="color: #393f81; justify-content: start; display: flex;">Already have an account? <a href="login.php" style="color: #393f81;">Login Here.</a></p>
        
        
                    </form>
                    </div>
                  </div>
            </div>
        </div>

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
        if(isset($_SESSION['status_success']) ){
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
                icon: 'success',
                title: 'Record Successfuly Added!'
                })

            </script>
            <?php
            unset($_SESSION['status_success']);
        }
    ?>
</body>