<?php
session_start();
include 'mysql_connect.php';

// prevent unauthenticated user and not student user to access this page
if (isset($_SESSION['isLogin'])) {
    if (!$_SESSION['isLogin']) {
        header('Location:login.php');
    } else {
        if ($_SESSION['account_type'] == "student") {
            header('Location:studentDashboard.php');
        }
    }
} else {
    echo '<script>';
    echo 'alert("Please Login your Account!")';
    echo '</script>';
    header('Location:login.php');
}

// $subject_id = "";
// if (isset($_GET['subject_id'])) {
//     $subject_id = $_GET['subject_id'];
//     $sql = "SELECT * FROM  subject WHERE subject_id=" . $subject_id;
//     $res = mysqli_query($conn, $sql);
//     if (mysqli_num_rows($res) > 0) {

//         $subject_details = mysqli_fetch_assoc($res);
//     }
// }



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    </head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<!-- <link rel="stylesheet" href="style.css"> -->
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
        /* background-color: #F8FAFB; */
    }
</style>
<body>

    <nav class="navbar navbar-light bg-dark">
        <a href="index.php" class="navbar-brand text-white">Student Record System</a>
        <form action="logout.php" method="POST">
            <button type="submit" name='logout' class="btn btn-danger  "> <i class="bi bi-person-dash-fill"></i> Logout</button>
        </form>
    </nav>

    <div class="container mt-3">
        <h2 class="text-center">Student</h2>
        <div id="table" class="text-dark mx-2"></div>
    </div>
    <div class="container-fluid mt-5 px-3 py-3">
        <div class="row">
            <div class="card mb-3 border-0 ml-2" style="max-width: 740px;">
            <div class="row no-gutters">
                <div class="col-md-4">
                <img src="img/avatar.svg" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body ml-lg-5">
                    <h1 class="card-title">John Doe</h1>
                    <p class="card-text">LRN: 313</p>
                    <p class="card-text">Guardian Name: Maria Clara</p>
                    <p class="card-text">Gender: Male</p>
                    
                </div>
                </div>
            </div>   
        </div>
        <div class="col-sm-6">
            <div class="row justify-content-end">
                <div class="card" style="width: 15vw;">
                <div class="card-body">
                    <h3>Present <span class="text-success"><i class="bi bi-check-circle-fill"></i></span></h3>
                    <p>34 Students</p>
                </div>
            </div>
            <div class="card ml-4" style="width: 15vw;">
                <div class="card-body">
                    <h3>Absent <span class="text-danger"><i class="bi bi-x-circle-fill"></i></span></h3>
                    <p>2 Students</p>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>
    <div class="container-fluid text-center mt-5">
        <div class="row row-cols-1 row-cols-md-2">
        <div class="col mb-4">
            <div class="card" style="background-color: #F8FAFB;"> 
                <div class="card-body">
                    <h2 class="card-title">1st Quarter</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="prerogative">Prerogative</label>
                            <input type="text" class="form-control" id="prerogative" name="prerogative">
                            
                        </div>
                        <div class="form-group">
                            <label for="summative">Summative</label>
                            <input type="text" class="form-control" id="summative" name="summative">
                        </div>
                        <div class="form-group">
                            <label for="exam">Exam</label>
                            <input type="text" class="form-control" id="exam" name="exam">
                        </div>
                         <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" id="total" name="total" disabled>
                        </div>
                    
                        <button type="submit" class="btn btn-warning text-white"><span><i class="bi bi-plus-circle-fill"></i></span> Add</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card" style="background-color: #F8FAFB;">
                <div class="card-body">
                    <h2 class="card-title">2st Quarter</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="prerogative">Prerogative</label>
                            <input type="text" class="form-control" id="prerogative" name="prerogative">
                            
                        </div>
                        <div class="form-group">
                            <label for="summative">Summative</label>
                            <input type="text" class="form-control" id="summative" name="summative">
                        </div>
                        <div class="form-group">
                            <label for="exam">Exam</label>
                            <input type="text" class="form-control" id="exam" name="exam">
                        </div>
                    
                        <button type="submit" class="btn btn-warning text-white"><span><i class="bi bi-plus-circle-fill"></i></span> Add</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card" style="background-color: #F8FAFB;"> 
                <div class="card-body">
                    <h2 class="card-title">3rd Quarter</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="prerogative">Prerogative</label>
                            <input type="text" class="form-control" id="prerogative" name="prerogative">
                            
                        </div>
                        <div class="form-group">
                            <label for="summative">Summative</label>
                            <input type="text" class="form-control" id="summative" name="summative">
                        </div>
                        <div class="form-group">
                            <label for="exam">Exam</label>
                            <input type="text" class="form-control" id="exam" name="exam">
                        </div>
                    
                        <button type="submit" class="btn btn-warning text-white"><span><i class="bi bi-plus-circle-fill"></i></span> Add</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card" style="background-color: #F8FAFB;">
                <div class="card-body">
                    <h2 class="card-title">4th Quarter</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="prerogative">Prerogative</label>
                            <input type="text" class="form-control" id="prerogative" name="prerogative">
                            
                        </div>
                        <div class="form-group">
                            <label for="summative">Summative</label>
                            <input type="text" class="form-control" id="summative" name="summative">
                        </div>
                        <div class="form-group">
                            <label for="exam">Exam</label>
                            <input type="text" class="form-control" id="exam" name="exam">
                        </div>
                    
                        <button type="submit" class="btn btn-warning text-white"><span><i class="bi bi-plus-circle-fill"></i></span> Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>




</body>



<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.setAttribute("class", "out");
    };


    var loadFile2 = function(event) {
        var image = document.getElementById('output2');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.setAttribute("class", "out");
    }
</script>

</html>